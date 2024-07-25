<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index() {
        $ArticleController = new ArticleController();
        $articles = $ArticleController->getLatestArticles();

        // Trả về view 'index.blade.php' với dữ liệu của các bài viết
        return view('index', ['articles' => $articles]);
    }
}
