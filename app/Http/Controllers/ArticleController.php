<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('post');
    }

    public function getLatestArticles()
    {
        $articles = DB::table('articles')
            ->join('users', 'articles.author_id', '=', 'users.user_id')
            ->join('categories', 'articles.category_id', '=', 'categories.category_id')
            ->select('articles.*', 'users.full_name as author_name', 'categories.category_name as category')
            ->orderBy('articles.publish_date', 'desc')
            ->take(3)
            ->get();

        return $articles;
    }

    public function articleDetail($id){
        $articledetail = DB::table('articles')
            ->join('users', 'articles.author_id', '=', 'users.user_id')
            ->select('articles.*', 'users.full_name as author_name')
            ->orderBy('articles.publish_date', 'desc')
            ->where('article_id','=',$id)->first();

        return view('article', ['data'=>$articledetail]);

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
