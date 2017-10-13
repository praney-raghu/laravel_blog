<?php

namespace Blog\Http\Controllers;

use Illuminate\Http\Request;
use Blog\Post;
use Blog\Comment;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
 	public function __construct()
 	{
 		$this->middleware(['auth'])->except('index','show');
 	} 

 	public function index()  
 	{
 		$posts = Post::orderby('id', 'desc')->paginate(5);
 		//dd($posts);
 		return view('posts.index', compact('posts'));
 	}

 	public function create()
 	{
 		return view('posts.create');
 	}

 	public function store(Request $request)
 	{
 		$this->validate($request, ['title'=>'required|max:100','body'=>'required',]);
 		$title = $request['title'];
 		$body = $request['body'];

 		$post = Post::create($request->only('title','body'));

 		return redirect()->route('posts.index')->with('flash_message','Post, '. $post->title.' created.');
 	}

 	public function show($id)
 	{
 		$post = Post::findOrFail($id);
 		$ids = DB::table('posts_has_comments')->where('post_id', $post->id)->get();//->all();
 		
 		if(!($ids->isEmpty())) 		
 		
 		{
 			$comments = Comment::findOrFail($ids->pluck('comment_id')->all());
 			//dd($comments);
 			$data['name'] = $comments->pluck('name')->all();
 			$data['body'] = $comments->pluck('body')->all();
 			$data['id'] = $ids->pluck('comment_id')->all();
 			//dd($data);
 			
 			$i = count($data['name']) - 1;			
 			return view('posts.show', compact('post','data','i'));
 		}
 		else
 		{
 		 	$data = NULL;
 		 	$i = -1;
 		 	return view('posts.show', compact('post','data','i'));
 		}
 	}

 	public function edit($id)
 	{
 		$post = Post::findOrFail($id);

 		return view('posts.edit', compact('post'));
 	}

 	public function update(Request $request, $id)
 	{
 		$this->validate($request, ['title'=>'required|max:100','body'=>
 			'required',]);
 		$post = Post::findOrFail($id);
 		$post->title = $request->input('title');
 		$post->body = $request->input('body');
 		$post->save();

 		return redirect()->route('posts.show',$post->id)->with('flash_message','Post, '. $post->title.' updated.');
 	}

 	public function destroy($id)
 	{
 		$post = Post::findOrFail($id);
 		$post->delete();

 		return redirect()->route('posts.index')->with('flash_message',
 			'Post successfully deleted.');
 	}
}
