<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostCommentController extends Controller {
	public function create(Request $request) {
		dd($request->all());
	}
}
