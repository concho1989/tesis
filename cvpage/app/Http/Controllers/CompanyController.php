<?php

namespace App\Http\Controllers;

class CompanyController extends Controller {


	public function __construct()
    {
        $this->middleware('auth:company');
    }

	public function dashboard() {

		return view('companyDashboard');
	}
}
