<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Http\Request;
use Validator;

class CompanyController extends Controller {

	public function createEmpresa(Request $request) {

		//comprobamos sí enviamos el formulario por el método "post"
		if ($request->isMethod('post')) {
			//Roles de validación
			$rules = [
				'name' => 'required|min:3|max:16|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
				'email' => 'required|email|max:255|unique:users,email',
				'password' => 'required|min:6|max:18|confirmed',
			];

			//Posibles mensajes de error de validación
			$messages = [
				'name.required' => 'El campo es requerido',
				'name.min' => 'El mínimo de caracteres permitidos son 3',
				'name.max' => 'El máximo de caracteres permitidos son 16',
				'name.regex' => 'Sólo se aceptan letras',
				'email.required' => 'El campo es requerido',
				'email.email' => 'El formato de email es incorrecto',
				'email.max' => 'El máximo de caracteres permitidos son 255',
				'email.unique' => 'El email ya existe',
				'password.required' => 'El campo es requerido',
				'password.min' => 'El mínimo de caracteres permitidos son 6',
				'password.max' => 'El máximo de caracteres permitidos son 18',
				'password.confirmed' => 'Los passwords no coinciden',
			];

			$validator = Validator::make($request->all(), $rules, $messages);

			//Si la validación no es correcta redireccionar al formulario con los errores
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator);
			} else {
				// De los contrario guardar al usuario
				$user = new Company;
				$user->name = $request->name;
				$user->direccion = $request->direccion;
				$user->file = $request->file($width = 40, $height = 40);
				$user->email = $request->email;
				$user->password = bcrypt($request->password);
				$user->descripcion = $request->descripcion;
				$user->cellphone = $request->cellphone;
				//Activar al administrador sin necesidad de enviar correo electrónico
				//	$user->active = 1;
				//El valor 1 en la columna determina si el usuario es administrador o no
				//	$user->user = 1;

				if ($user->save()) {
					return redirect()->back()->with('message', 'Enhorabuena nueva empresa creada correctamente');
				} else {
					return redirect()->back()->with('error', 'Ha ocurrido un error al guardar los datos');
				}
			}
		}

		return View('admin.empresa.createempresa');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$companies = Company::orderBy('id', 'DESC')->paginate();
		return view('admin.companies.index', compact('companies'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.companies.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CompanyStoreRequest $request) {
		$company = Company::create($request->all());
		return redirect()->route('companies.edit', $company->id)
			->with('info', 'Empresa creada con éxito');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Company $slug) {
		dd($slug->cellphone);
		$company = Company::find($slug);
		return view('admin.companies.show', compact('company'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$company = Company::find($id);
		return view('admin.companies.edit', compact('company'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(CompanyUpdateRequest $request, $id) {
		$company = Company::find($id);
		$company->fill($request->all())->save();
		return redirect()->route('companies.edit', $company->id)
			->with('info', 'Empresa actualizada con éxito');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$company = Company::find($id)->delete();
		return back()->with('info', 'Eliminado correctamente $company');
	}

	public function CompanySignUp(Request $request) {
		$name = $request['name'];
		$time_expe = $request['time_expe'];
		$file = $request['file'];
		$descripcion = $request['descripcion'];
		$cellphone = $request['cellphone'];
		$email = $request['email'];
		$password = bcrypt($request['password']);

		$company = new Company();
		$company->name = $name;
		$company->time_expe = $time_expe;
		$company->file = $file;
		$company->descripcion = $descripcion;
		$company->cellphone = $cellphone;
		$company->email = $email;
		$company->password = $password;

		$company->save();
		if ($company->save()) {
			return redirect()->back()->with('message', 'Enhorabuena nueva empresa creada correctamente');
		} else {
			return redirect()->back()->with('error', 'Ha ocurrido un error al guardar los datos');
		}

	}

	public function dashboard() {
		return view('companyDashboard');
	}

	public function CompanySignIn(Request $request) {

	}

	public function mensajeTxt(){
		$users = User::all();
		
		return view('admin.companies.partials.sendmessage',['users' => $users]);
	}

	public function getUsers(){
		$users = User::all();
		return $users;
		//return view('admin.companies.partials.sendmessage');
	}

	public function sendmessage(Request $request){
		$message  = $request->input('message');
		$cellphone  = $request->input('cellphone');

		$encodeMessage = urlencode($message);
		$authkey ='';
		$senderId ='';
		$route = 4;
		$postData = $request->all();
	
		$cellphoneNumber = implode('', $postData['cellphone']);
		
		$arr = str_split($cellphoneNumber, '14');
		$cellphones = implode(",", $arr);
		//print_r($cellphones);
		//exit();
		$data = array(
			'authkey' => $authkey,
			'cellphones' => $cellphones,
			'message' => $encodeMessage,
			'sender' => $senderId,
			'route' => $route,
		);
		$url = "ttp"; //falta agregar cuenta de twilio
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData,
			//CURLOP_FOLLOWLOCATION = true
		));

	//ignore SSL certificate verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);

	//GET RESPONSE
	$output = curl_exec($ch);

	//print error if any
	if(curl_errno($ch))
	{
		echo 'error' .curl_error($ch);
	}	
	curl_close($ch);
	return redirect('/')->with('response', 'Mensaje Enviado'); 

	}
}
