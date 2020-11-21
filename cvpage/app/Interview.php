<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model {
	/*fillable para guardar datos de forma masiva*/
	protected $fillable = [
		'user_id', 'company_id', 'especialidad', 'time_experiencia', 'pregunta_1', 'pregunta_2', 'pregunta_3', 'porcentaje', 'status',
	];

	
	public function company() {
		// por que una entrevista pertenece a una empresa
		return $this->belongsTo(Company::class);
	}
}
