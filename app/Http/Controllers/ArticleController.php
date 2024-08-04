<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Comment;

class ArticleController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categories = Category::getCategories();
        $articles = Article::getArticlesById($id);
        return view('admin.article.updateArticle', ['data' => $articles, 'categories' => $categories]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::getAllArticles();
        return view('admin.article.article', ['data' => $articles]);
    }

    public function articleDetail($id)
    {
        try {
            $articledetail = Article::getArticleDetail($id);

                if (!$articledetail || $articledetail->status == 0) {
                    return ([
                        'alert', [
                            'type' => 'error',
                            'message' => 'The article does not exist or is not public.',
                        ]
                    ]);
                }
               
                
            $nextArticle = Article::nextArticle($articledetail);
            
            $previousArticle = Article::previousArticle($articledetail);


            $getCategoryCount = Category::getCategoryCount();



            $recentArticles = Article::recentArticles();

            foreach ($recentArticles as $article) {
                $article->time_since_posted = Carbon::parse($article->created_at)->diffForHumans();
            }


            $sumComment=Comment::sumComment($id);
            $getCommentById=Comment::getCommentById($id);

            return view('article', [
                'data' => $articledetail,
                'nextArticle' => $nextArticle,
                'previousArticle' => $previousArticle,
                'categories' => $getCategoryCount,
                'recentArticles' => $recentArticles,
                'sumComment' => $sumComment,
                'getCommentById' => $getCommentById
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => $th->getMessage()
            ]);

            // dd($th);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.article.addArticle', ['categories' => $categories]);
    }

    public function updateStatus(Request $request)
    {
        $article = Article::find($request->id);
        if ($article) {
            $article->status = $request->has('status') ? 1 : 0;
            $article->save();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Article status updated successfully.'
            ]);
        }
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'message' => 'Article to update category status.'
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'content' => 'required|string',
                'category_id' => 'required|integer|exists:categories,id',
                'img_article' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            $imageName = 'img_article' . time() . '_'
                . $request->name . '.'
                . $request->img_article->extension();
            $imagePath = $request->file('img_article')->storeAs('public/admin/article', $imageName);
            // Chuẩn bị dữ liệu để lưu
            $data = [
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'content' => $validatedData['content'],
                'author_id' => Auth::id(),
                'category_id' => $validatedData['category_id'],
                'image_url' => 'storage/admin/article/' . $imageName,
                'views' => $request->input('views', 0),
                'status' => $request->input('status', 1),
                'created_at' => now(),
            ];
            $addResult = DB::table('articles')->insert($data);

            if ($addResult) {
                return redirect()->back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Article has been successfully added!'
                ]);
            } else {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'message' => 'Failed to add Article. Please try again.'
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => $th->getMessage()
            ]);

            // dd($th);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::getCategories();
        $query = Article::showId($id);
        return view('admin.article.updateArticle', ['data' => $query, 'category' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $post=DB::table('articles')->get();
        try {
            // Xác thực dữ liệu từ request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'content' => 'required|string',
                'category_id' => 'required|integer|exists:categories,id',
                'img_article' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $article = DB::table('articles')->where('id', $id)->first();
            // Chuẩn bị dữ liệu để cập nhật
            $data = [
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'content' => $validatedData['content'],
                'category_id' => $validatedData['category_id'],
            ];
            $data['image_url'] = $article->image_url;
            if ($request->hasFile('img_article')) {
                if (file_exists(public_path($article->image_url))) {
                    unlink(public_path($article->image_url));
                }
                $imageName = 'img_article' . time() . '_'
                    . $request->name . '.'
                    . $request->img_article->extension();
                $imagePath = $request->file('img_article')->storeAs('public/admin/article', $imageName);
                $data['image_url'] = 'storage/admin/article/' . $imageName;
            } else {
                $data['image_url'] = $article->image_url;
            }
            // dd($data);
            $updateResult = Article::updateArticle($id, $data);
            if ($updateResult) {
                return redirect()->back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Bài viết đã được chỉnh thành công!'
                ]);
            } else {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'message' => ' Bạn không thay đổi gì .'
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Có lỗi xảy ra khi tải lên ảnh: ' . $th->getMessage()
            ]);
            // dd($th);
        }
    }

    public function status(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $article = Article::find($id);
            if ($article) {
                $article->delete();
                if (file_exists(public_path($article->image_url))) {
                    unlink(public_path($article->image_url));
                }
                return redirect()->back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Article deleted successfully!'
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => ' Lỗi : ' . $th->getMessage()
            ]);
        }
    }
}
