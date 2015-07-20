<?php

class AuthController extends BaseController
{

	public function logout()
	{
		if (Auth::check()) 
		{
			Auth::logout();
		}

		return Redirect::to('/');
	}

	public function get_login_form()
	{
		return View::make('login')->with('url', Input::get('url'));
	}

	public function create_account_view()
	{
		return View::make('signup');
	}

	public function post_login()
	{
		$rules = array(
				'email' => 'required|email',
				'password' => 'required|min:4'
			);

		$remember = false;

		if ( Input::has('remember') )
		{
			$remember = true;
		}

		$validated = Validator::make(Input::all(), $rules);

		if ($validated->fails()) 
		{
			return Redirect::to('login')
							->withInput(Input::except(array('password')))
							->withErrors($validated);
		}

		$userdata = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);

		if (Auth::attempt($userdata,$remember)) 
		{
			if ( Input::has('url') && Input::get('url') != '' ) 
			{
				return Redirect::to(Input::get('url'));
			}
			else
			{
				return Redirect::intended('/');
			}
		}
		else
		{
			return Redirect::to('login')
							->withInput(Input::except(array('password')))
							->withErrors($validated);
		}
	}

	public function create_account()
	{
		
		$rules = array(
				'name' 				=> 'required',
				'username'			 => 'required',
				'email' => 'required|email',
				'password' => 'required|min:4',
				'password_confirm' => 'required|same:password',
			);

		$validated = Validator::make(Input::all(), $rules);

		if ($validated->fails()) 
		{
			return Redirect::to('signup')
							->withErrors($validated)
							->withInput(Input::except(array('password','password_confirm')));
		}

		$new_user = new User();
		$new_user->name = Input::get('name');
		$new_user->username = Input::get('username');
		$new_user->email = Input::get('email');
		$new_user->password = Hash::make(Input::get('password'));
		$new_user->save();

		if ($new_user->save()) 
		{
			Auth::loginUsingId($new_user->id);

			return Redirect::to('/');	
		}

	}
}
