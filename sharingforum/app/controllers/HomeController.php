<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('home');
	}

	public function display_about()
	{
		return View::make('about');
	}

	public function test()
	{
		$reliability_value = Reliability::where('solution_id', '=', 6)
												->where('user_id', '=', 5)
												->pluck('reliability');

		dd($reliability_value);
	}

	public function send_email()
	{
		$name=Input::get('name');
		$email=Input::get('email');
		$usermessage=Input::get('message');
		Mail::send('emails.auth.reminder', array('usermessage'=>$usermessage), function($message) use($name, $email)
		{
			$message->to('sicnare@gmail.com' ,'francis muriithi')
					->subject('From KU Student Sharing Forum')
					->from($email, $name);
		});


		return Redirect::to('/');
	}

}
