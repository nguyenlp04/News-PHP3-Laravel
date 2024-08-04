<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public static function getCommentById($id) {
        return DB::table('comments')
        ->leftJoin('users' , 'comments.user_id','=','users.id')
        ->select('comments.*' , 'users.name as name')
        ->where('comments.article_id',$id)
        ->orderBy('comments.created_at', 'desc')
        ->paginate(5);

    }
    public static function getComment() {
        return DB::table('comments')
        ->leftJoin('users', 'comments.user_id', '=', 'users.id')
        ->leftJoin('articles', 'comments.article_id', '=', 'articles.id')
        ->select('comments.*', 'users.name as user_name', 'articles.title as article_title', 'articles.id as article_id')
        ->get();

    }
    public static function sumComment($id)  {
        return DB::table('comments')->where('article_id', $id)
        ->count('article_id');

    }
}