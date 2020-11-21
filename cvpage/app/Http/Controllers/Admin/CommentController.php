<?php

namespace App\Http\Controllers\Admin;

use App\Comments;
use App\Http\Controllers\Controller;
use App\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function getHome() {
		$comments = Comments::orderBy('created_at', 'DESC')->get();
		return view('web.post', ['comments' => $comments]);
	}

	public function commentCreateComment(Request $request) {
		$comments = Comments::orderBy('created_at', 'DESC')->get();
		//Validation
		$this->validate($request, [
			'comment' => 'required|max:140',
			//'date' => 'required|date:(Y-m-d)',
			//'time' => 'required|date:(H:m:s)',
		]);
		$comment = new Comments();
		$comment->comment = $request['comment'];
		//$date->comment = $request['date'];
		//$time->comment = $request['time'];
		$message = 'Hubo un error a Publicar';
		if ($request->user()->comments()->save($comment)) {
			$message = 'Comentario publicado sastifactoriamente!';
		}
		return redirect()->back()->with(['message' => $message]);

	}

	public function getDeleteComment($comment_id) {
		$comment = Comments::where('id', $comment_id)->first();
		if (Auth::user() != $comment->user) {
			return redirect()->back();
		}
		$comment->delete();
		return redirect()->back()->with(['message' => 'Comentario eliminado']);
	}

	public function editComment(Request $request) {
		$this->validate($request, [
			'comment' => 'required|max:140',
		]);

		$comment = Comments::find($request['commentId']);
		if (Auth::user() != $comment->user) {
			return redirect()->back();
		}
		$comment->comment = $request['comment'];
		$comment->update();
		return response()->json(['new_comment' => $comment->comment], 200);
	}

	public function LikeComment(Request $request) {
		$comment_id = $request['commentId'];
		$is_like = $request['isLike'] === 'true';
		$update = false;
		$comment = Comments::find($comment_id);
		if (!$comment) {
			return null;
		}
		$user = Auth::user();
		$like = $user->likes()->where('comment_id', $comment_id)->first();
		if ($like) {
			$already_like = $like->like;
			$update = true;
			if ($already_like == $is_like) {
				$like->delete();
				return null;
			}
		} else {
			$like = new Like();
		}
		$like->like = $is_like;
		$like->user_id = $user->id;
		$like->comment_id = $comment->id;
		if ($update) {
			$like->update();
		} else {
			$like->save();
		}
		return null;
	}
}
