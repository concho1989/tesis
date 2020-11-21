<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$rules = [
			'interview_id' => 'required|unsigned',
			'user_id' => 'required|unsigned',
			'name' => 'required',
			'direccion' => 'required|unique',
			'email' => 'required|unique',
			'descripcion' => 'nullable',
			'cellphone' => 'required|integer',
		];
		if ($this->get('file')) {
			$rules = array_merge($rules, ['file' => 'mimes:jpg,jpeg,pnp,bmp']);
		}

		return $rules;
	}
}
