<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

	protected $fillable = [
		'user_id', 'category_id', 'name', 'slug', 'description', 'status', 'file',
	];

	public function user() {
		// por que un post pertenece a un usuario
		return $this->belongsTo('App\User'); //belongsTo ----->> pertenece a ...

	}

	public function category() {
		// por que un post pertenece a una categoria
		return $this->belongsTo(Category::class); //belongsTo ----->> pertenece a ...

	}

	public function tags() {
		// tags por que un posts tiene muchos etiquetas
		return $this->belongsToMany(Speciality::class); // belongsToMany() PERTENECE Y TIENE MUCHOS

	}

	public function comments() {
		//  por que un posts tiene muchos comments
		return $this->hasMany('App\Comments', 'post_id'); //hasMany()  TIENE MUCHOS

	}
	public function likes() {
		return $this->hasMany('App\Likespos');
	}
}
