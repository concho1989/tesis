<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\Comments;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;

class PageController extends Controller {

	public function blog() {
		$posts = Post::orderBy('id', 'DESC')->where('status', 'PUBLISHED')->paginate(5);
		$comments = Comments::all();
		return view('web.posts', compact('posts', 'comments'));
	}

	public function category($slug) {
		$category = Category::where('slug', $slug)->pluck('id')->first();
		$posts = Post::where('category_id', $category)
			->orderBy('id', 'DESC')->where('status', 'PUBLISHED')->paginate(5);
		return view('web.posts', compact('posts'));
	}

	public function tag($slug) {
		$posts = Post::whereHas('tags', function ($query) use ($slug) {
			$query->where('slug', $slug);
		})
			->orderBy('id', 'DESC')->where('status', 'PUBLISHED')->paginate(5);
		return view('web.posts', compact('posts'));
	}

	public function post($slug) {
		$post = Post::where('slug', $slug)->first();
		return view('web.post', compact('post'));
	}

	public function user($users) {
		$users = User::orderBy('id', 'DESC')->get();
		return view('web.post', compact('users'));
	}

}
