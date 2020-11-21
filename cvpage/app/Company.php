<?php

namespace App;
use App\Notifications\ResetPasswordNotification;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable {
	use Notifiable, HasRolesAndPermissions;

	protected $guard = 'company';

	protected $fillable = [
		'user_id', 'interview_id', 'name', 'time_expe', 'direccion', 'file', 'email', 'descripcion', 'cellphone', 'password',
	];

	public function interviews() {
		return $this->belongsToMany(Interview::class);
	}

	public function users() {
		return $this->belongsToMany(User::class);
	}
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */

	protected $hidden = [
		'password', 'remember_token',
	];

	public function sendPasswordResetNotification($token) {
		$this->notify(new ResetPasswordNotification($token));
	}
}
