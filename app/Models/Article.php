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
