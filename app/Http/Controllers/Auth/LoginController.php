<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/superuser';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}

	protected function validator(array $data) {
		return Validator::make($data, [
			'email'    => 'required|exists:users,email',
			'password' => 'required',
		]);
	}

//	protected function sendFailedLoginResponse(Request $request) {
//		return redirect()->back()->withErrors('login', 'n_valid');
//	}


	public function form() {
		if (\Auth::check()) {
			return redirect('/superuser');
		}

		return view('admin.login');
	}
}
