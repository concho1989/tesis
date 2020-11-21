<?php

namespace App;
use App\Notifications\ResetPasswordNotification;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable, HasRolesAndPermissions;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'interview_id', 'company_id', 'name', 'file', 'email', 'password', 'cellphone',
		'user'];

	public function interviews() {
		// porque un usuario tiene y pertenece a muchas entrevistas
		return $this->belongsToMany(Interview::class);
	}

	public function post() {
		//porque un usuario tiene un solo post
		return $this->belongsTo(Post::class);
	}

	public function companies() {
		// porque un usuario trabaja en muchas empresas
		return $this->hasMany(Company::class);
	}

	public function specialities() {
		// porque un usuario tiene en muchas especialidades
		return $this->hasMany(Speciality::class);
	}

	public function comments() {
		// porque un usuario tiene muchos posts
		return $this->hasMany('App\Comments');
	}

	public function likes() {
		return $this->hasMany('App\Likespos');
	}

	public function roles() {
		return $this->belongsToMany(Role::class)->withTimestamps();
	}

	public function authorizeRoles($roles) {
		abort_unless($this->hasAnyRole($roles), 401);
		return true;
	}
	public function hasAnyRole($roles) {
		if (is_array($roles)) {
			foreach ($roles as $role) {
				if ($this->hasRole($role)) {
					return true;
				}
			}
		} else {
			if ($this->hasRole($roles)) {
				return true;
			}
		}
		return false;
	}
	public function hasRole($role) {
		if ($this->roles()->where('name', $role)->first()) {
			return true;
		}
		return false;
	}

	public function messages() {
		return $this->hasMany(Message::class);
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
