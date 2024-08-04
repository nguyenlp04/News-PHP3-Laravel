<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    
   

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

        $allArticles = Article::getAllArticlesCategory();

        $categories = Category::getCategoryActive();
    
    $categoryArticles = [];
    
    
    // Lấy tối đa 8 bài viết cho từng thể loại
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
        $randomArticles = Article::randomArticles();

        // Lấy các bài viết vừa đọc
        // $recentlyReadArticles = DB::table('recent_reads')
        //     ->select('articles.*', 'categories.name as categories_name')
        //     ->leftJoin('articles', 'recent_reads.article_id', '=', 'articles.id')
        //     ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
        //     ->where('recent_reads.user_id', Auth::id())
        //     ->orderBy('recent_reads.read_at', 'desc')
        //     ->limit(8)
        //     ->get();

        // Lấy 4 bài viết gợi ý ngẫu nhiên
        $recommendedArticles = DB::table('articles')
            ->select('articles.*', 'categories.name as categories_name')
            ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.status', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('index', [
            'allArticles' => $allArticles,
            'featuredArticle' => $featuredArticle,
            'subArticles' => $subArticles,
            'sideArticles' => $sideArticles,
            'categoryArticles' => $categoryArticles,
            'randomArticles' => $randomArticles,
            'categories' => $categories,
            // 'recentlyReadArticles' => $recentlyReadArticles,
            'weeklyTopNews' => $weeklyTopNews,
            'recommendedArticles' => $recommendedArticles
        ]);
    }
}
