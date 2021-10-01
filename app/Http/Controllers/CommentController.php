<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $post = Post::find($request->get('post_id'));
        $post->comments()->save($comment);
        return Redirect()->back()->with('success', 'Comment added succeefully.');
    }

    public function replyStore(Request $request)
    {
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Post::find($request->get('post_id'));
        $post->comments()->save($reply);
        return Redirect()->back()->with('success', 'Reply sent succeefully.');
    }

    public function commentDelete(Request $request, $id)
    {
        $deleteNestedComment = Comment::where('parent_id', $id)->Orwhere('id', $id)->delete();
        if ($deleteNestedComment) {
            return Redirect()->back()->with('success', 'Comment added succeefully.');
        } else {
            return Redirect()->back()->with('error', 'Somthing went to wrong!');
        }
    }
}
