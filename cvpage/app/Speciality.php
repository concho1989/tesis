<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model {
	protected $fillable = [
		'name', 'slug',
	];

	public function posts() {
		// por que un post tiene muchos etiquetas
		return $this->belongsToMany(Post::class); // belongsToMany() PERTENE Y TIENE MUCHOS

	}
}
