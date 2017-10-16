<?php

namespace Blog\Http\Controllers;

use Illuminate\Http\Request;
use Blog\Comment;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function store(Request $request)
 	{
 		$this->validate($request, ['body'=>'required',]);
 		$name = Auth::user()->name;
 		$body = $request['body'];
 		$id = $request->id;

 		$comment = new Comment;
 		$comment->name = $name;
 		$comment->body = $body;
 		$comment->save();

 		$cmnt_id = $comment->id;

 		DB::table('posts_has_comments')->insert([
 			'post_id'=>$id,'comment_id'=>$cmnt_id
 		]);

 		return redirect()->route('posts.show',$id);
 	}
 	
 	public function update(Request $request, $id)
 	{
 		$this->validate($request, ['body'=>'required',]);
 		$comment = Comment::findOrFail($id);
 		$comment->body = $request->input('body');
 		$comment->save();

 		$post = DB::table('posts_has_comments')->where('comment_id', $id)->first();
 		$post_id = $post->post_id;

 		return redirect()->route('posts.show',$post_id)->with('flash_message','Comment successfully updated.');
 	}

 	public function destroy($id)
 	{
 		$comment = Comment::findOrFail($id);

 		$post = DB::table('posts_has_comments')->where('comment_id', $id)->first();
 		$post_id = $post->post_id;

 		$comment->delete();

 		return redirect()->route('posts.show',$post_id)->with('flash_message',
 			'Comment successfully deleted.');
 	}
}
