<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model {
	public $timestamps = false;
	protected $fillable =
		['user_id', 'post_id', 'comment'];

	public function user() {
		//porque muchos comments le pertenece a un usuario
		return $this->belongsTo('App\User');
	}
	public function post() {
		return $this->belongsTo('App\Post');
	}
}
