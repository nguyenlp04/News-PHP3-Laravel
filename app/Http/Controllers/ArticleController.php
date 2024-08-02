<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ArticleController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $articles = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.id', $id)
            ->first();
        return view('admin.article.updateArticle', ['data' => $articles]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index() {

        $articles = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.status', 1)
            ->orderBy('articles.created_at', 'desc')
            ->get();

            $featuredArticle = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.status', 1)
            ->orderBy('articles.created_at', 'desc')
            ->first();
    
        $subArticles = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.status', 1)
            ->orderBy('articles.created_at', 'desc')
            ->limit(3)
            ->get();
    
        $sideArticles = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.status', 1)
            ->orderBy('articles.created_at', 'desc')
            ->limit(6)
            ->get();


        // Lấy thông tin thời gian đầu và cuối tuần hiện tại
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
    
        // Lấy các tin tức nổi bật trong tuần hiện tại
        $weeklyTopNews = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.status', 1)
            ->whereBetween('articles.created_at', [$startOfWeek, $endOfWeek])
            ->orderBy('articles.created_at', 'desc')
            ->get();
    
        // Lấy danh sách thể loại
        $categories = DB::table('categories')->get();
    
        // Khởi tạo mảng để chứa các bài viết của mỗi thể loại
        $categoryArticles = [];
    
        // Lấy tối đa 8 bài viết cho mỗi thể loại
        foreach ($categories as $category) {
            $categoryArticles[$category->id] = DB::table('articles')
                ->select('articles.*', 'categories.name as categories_name')
                ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
                ->where('articles.status', 1)
                ->where('articles.category_id', $category->id)
                ->orderBy('articles.created_at', 'desc')
                ->limit(8)
                ->get();
        }
    
        // Lấy 8 bài viết ngẫu nhiên để hiển thị ở tab "All"
        $randomArticles = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.status', 1)
            ->inRandomOrder()
            ->limit(8)
            ->get();
    
        // Lấy các bài viết vừa đọc
        $recentlyReadArticles = DB::table('recent_reads')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('articles', 'recent_reads.article_id', '=', 'articles.id')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('recent_reads.user_id', Auth::id())
            ->orderBy('recent_reads.read_at', 'desc')
            ->limit(8)
            ->get();
    
        // Lấy 4 bài viết gợi ý ngẫu nhiên
        $recommendedArticles = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.status', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    
        return view('index', [
            'featuredArticle' => $featuredArticle,
            'subArticles' => $subArticles,
            'sideArticles' => $sideArticles,
            'categoryArticles' => $categoryArticles,
            'randomArticles' => $randomArticles,
            'recentlyReadArticles' => $recentlyReadArticles,
            'weeklyTopNews' => $weeklyTopNews,
            'recommendedArticles' => $recommendedArticles
        ]);
    }
    
    // public function getLatestArticles()
    // {
    //     $articles = DB::table('articles')
    //         ->join('users', 'articles.author_id', '=', 'users.id')
    //         ->join('categories', 'articles.category_id', '=', 'categories.id')
    //         ->select('articles.*', 'users.name as author_name', 'categories.name as category')
    //         ->orderBy('articles.created_at', 'desc')
    //         ->take(3)
    //         ->get();

    //     return $articles;
    // }


    
    public function articleDetail($id)
    {
        $articledetail = DB::table('articles')
            ->select('articles.*', 'users.name as author_name', 'categories.name as category_name', DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) as comment_count'))
            ->where('articles.status', 1)
            ->join('users', 'articles.author_id', '=', 'users.id')
            ->join('categories', 'articles.category_id', '=', 'categories.id')
            ->orderBy('articles.created_at', 'desc')
            ->where('articles.id', '=', $id)->first();

        $nextArticle = DB::table('articles')
            ->select('*')
            ->where('articles.status', 1)
            ->where('articles.created_at', '>', $articledetail->created_at)
            ->orderBy('articles.created_at', 'asc')
            ->first();

        $previousArticle = DB::table('articles')
            ->select('*')
            ->where('articles.status', 1)
            ->where('articles.created_at', '<', $articledetail->created_at)
            ->orderBy('articles.created_at', 'desc')
            ->first();

        $categories = DB::table('categories')
            ->where('categories.status', 1)
            ->leftJoin('articles', 'categories.id', '=', 'articles.category_id')
            ->select('categories.id', 'categories.name', DB::raw('COUNT(articles.id) as article_count'))
            ->groupBy('categories.id', 'categories.name')
            ->get();
        $recentArticles = DB::table('articles')
            ->select('articles.*')
            ->where('articles.status', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    
        foreach ($recentArticles as $article) {
            $article->time_since_posted = Carbon::parse($article->created_at)->diffForHumans();
        }
        return view('article', ['data' => $articledetail,
                            'nextArticle' => $nextArticle,
                            'previousArticle' => $previousArticle,
                            'categories' => $categories,
                            'recentArticles' => $recentArticles
                        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.article.addArticle');
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
                'author_id' => 'required|integer|exists:users,id',
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
                'author_id' => $validatedData['author_id'],
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
        $categories=DB::table('categories')->get();
        $query=Article::showId($id);
        return view('admin.article.updateArticle',['data'=>$query,'category'=>$categories]);
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
                return redirect()->back()->with('alert',[
                    'type'=>'success',
                    'message'=>'Article deleted successfully!'
            ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert',[
                'type'=>'error',
                'message'=>' Lỗi : '.$th->getMessage()
        ]);
        }
    }
}
