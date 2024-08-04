<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Article extends Model
{

    use HasFactory;
    protected $table='articles';
    protected $fillable = ['title', 'content', 'author_id', 'category_id', 'publish_date', 'status', 'views_count', 'image_url'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }




    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getArticlesById($id)
    {
        return DB::table('articles')
        ->select('articles.*', 'categories.name as categories_name')
        ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
        ->where('articles.id', $id)
        ->first();
    }  
    public static function getAllArticles()
    {
        return DB::table('articles')
        ->select('articles.*', 'categories.name as categories_name', 'users.name as author_name')
        ->leftJoin('users', 'articles.author_id', '=', 'users.id')
        ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
        ->orderBy('articles.created_at', 'desc')
        ->get();
    }  

    public static function getAllArticlesCategory()
    {
        return DB::table('articles')
        ->select('articles.*', 'categories.name as categories_name')
        ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
        ->where('articles.status', 1)
        ->inRandomOrder() 
        // ->limit(8) 
        // ->get();
        ->paginate(8);

    } 

    
    public static function getArticleDetail($id)
    {
        return DB::table('articles')
        ->select('articles.*', 'users.name as author_name', 'categories.name as category_name', DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) as comment_count'))
        ->where('articles.status', 1)
        ->join('users', 'articles.author_id', '=', 'users.id')
        ->join('categories', 'articles.category_id', '=', 'categories.id')
        ->orderBy('articles.created_at', 'desc')
        ->where('articles.id', '=', $id)->first();
    }

    public static function nextArticle($currentArticle)
    {
        return DB::table('articles')
        ->select('*')
        ->where('articles.status', 1)
        ->where('articles.created_at', '>', $currentArticle->created_at)
        ->orderBy('articles.created_at', 'asc')
        ->first();
    }


    public static function previousArticle($currentArticle)
    {
        return DB::table('articles')
        ->select('*')
        ->where('articles.status', 1)
        ->where('articles.created_at', '<', $currentArticle->created_at)
        ->orderBy('articles.created_at', 'desc')
        ->first();
    }

    public static function recentArticles()
    {
        return DB::table('articles')
        ->select('articles.*')
        ->where('articles.status', 1)
        ->inRandomOrder()
        ->limit(4)
        ->get();
    }


    public static function randomArticles()
    {
        return DB::table('articles')
        ->select('articles.*', 'categories.name as categories_name')
        ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')
        ->where('articles.status', 1)
        ->inRandomOrder()
        ->limit(8)
        ->get();
    }


    public static function index()
    {
        return DB::table('articles')
        ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')

        ->select(
            'articles.id',
            'articles.title',
            'articles.short_description',
            'articles.content',
            'articles.author_id',
            'articles.category_id',

            'articles.image_url',
            'articles.views',
            'articles.created_at',
            'categories.name as category_name',

        )
        ->get();
    }


    public static function updateArticle($id, $data)
    {
        try {
            return DB::table('articles')->where('id',$id)->update($data);
        } catch (\Throwable $th) {
            Log::error('Error inserting article: ' . $th->getMessage());
            return false;
        }
    }


    public static function showId($id)
    {
        return DB::table('articles')
        ->leftJoin('categories', 'articles.category_id', '=', 'categories.id')

        ->select(
            'articles.id',
            'articles.title',
            'articles.description',
            'articles.content',
            'articles.author_id',
            'articles.category_id',
            'articles.image_url',
            'articles.views',
            'articles.created_at',
            'categories.name as category_name',
        )
        ->where('articles.id','=',$id)
        ->get();
    }


}
