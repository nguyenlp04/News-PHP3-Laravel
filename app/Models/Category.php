<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $fillable = ['id', 'name', 'description', 'status', 'created_at', 'updated_at'];

    public function getCategories()
    {
        return DB::table('categories')->get();
    }

    public static function getCategoryActive()
    {
        return DB::table('categories')
        ->where('status', 1)
        ->get();
    }

    public static function getCategoryCount()
    {
        return DB::table('categories')
        ->leftJoin('articles', 'categories.id', '=', 'articles.category_id')
        ->select('categories.id', 'categories.name', DB::raw('COUNT(articles.id) as article_count'))
        ->where('articles.status', 1)
        ->groupBy('categories.id', 'categories.name')
        ->get();
    }
}
