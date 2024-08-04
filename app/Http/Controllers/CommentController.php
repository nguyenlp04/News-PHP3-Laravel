<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
        $query=Comment::getComment();
        return view('admin.comment.comment',['data'=>$query]);
    }

    public function addComment(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'article_id' => 'required|integer|exists:articles,id',
            'comment' => 'required|string|max:500',
        ]);

        DB::table('comments')->insert([
            'user_id' => $validatedData['user_id'],
            'article_id' => $validatedData['article_id'],
            'comment' => $validatedData['comment'],
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
   

public function destroy(string $id)
    {
        try {
            $comment = Comment::find($id);
            if ($comment) {
                $comment->delete();
                return redirect()->back()->with('alert',[
                    'type'=>'success',
                    'message'=>'Comment deleted successfully!'
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