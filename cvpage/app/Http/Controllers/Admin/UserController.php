<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Speciality;
use App\Company;
use Validator; 
use Auth;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {
	
	public function index() {
		$users = User::paginate();
		return view('admin.users.index', compact('users'));
	}

	public function show(User $role) {
		return view('admin.users.show', compact('role'));

	}
	/*Editamos los usuarios a nivel de roles*/
	public function edit($id) {
		$user = User::find($id);
		$roles = Role::get();

		return view('admin.users.edit', compact('user', 'roles'));
	}


	public function showperfil() {
		return view('admin.users.MainPerfil');
	}

	public function profile() {
			return view('admin.users.profile');
	}

	public function updateProfile(Request $request)
	{
		/*
		
		/*
	$rules = [ 
			'file' => 'required|file|max:768*468*1',];
		$messages =[
			'file.required' => 'Imgagen de Pefil es Requerida',
			'file.file' => 'Formato no Permetido',
			'file.max' => 'El maximo permitido es 1Mb'
		];
		

			$validator = Validator::make($request->all(), $rules,$messages);
			if($validator->fails()){
				return redirect()
				->route('showperfil')->withErrors($validator);
			}
			else{
				$name = str_random(15) . '_' . $request->file('file')->getClientOriginalName();
				$request->file('file')->move('file', $name);
				$user = new User();
				$user->where('email', '=', Auth::user()->email)
					 ->update(['file' => 'perfiles/' .$name]);
					 return redirect()
					->route('showperfil') 
					->with('success', 'Acceso Actuarizado');

			}*/
		
		
		
		$data = $request->all();
		$user = auth()->user();
		
			if($data['password'] != null)
				$data['password'] = bcrypt($data['password']);
			else
				unset($data['password']);
				$data['file'] = $user->file;
				if ($request->hasFile('file') && $request->file('file')->isValid()) {
					if ($user->file) {
						$name = $user->file;
					}else
					$name = $user->id.kebab_case($user->name);
					$extenstion = $request->file->extension();
					$nameFile = "{$name}";
					$data['file'] = $nameFile;

					$upload = $request->file->storeAs('users', $nameFile);
					if (!$upload) {
						return redirect()
						->route(showperfil)
						->with('error', 'Perfil cambaido con exito');
					}
					
				}
			

			$update = $user->update($data);

			if ($update) {
				return redirect()
					->route('showperfil') 
					->with('success', 'Acceso Actuarizado');

				return redirect()
					->route('showperfil') 
					->with('error', 'Error al enviar los datos');
			}
			
		}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$user = User::find($id);
		$user->update($request->all());

		$user->roles()->sync($request->get('roles'));

		return redirect()->route('admin.users.edit', $user->id)
			->with('info', 'Usuario guardado con éxito');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$user = User::find($id)->delete();

		return back()->with('info', 'Eliminado correctamente');
	}




}