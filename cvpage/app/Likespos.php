<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likespos extends Model
{
    protected $fillable = [
		'user_id','post_id',
	];

	public function user() {
		return $this->belongsTo('App\User');
	}

	
	public function posts() {
		return $this->hasMany('App\Post');
	}
}
