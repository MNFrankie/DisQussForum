<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');

Route::post('send-email', 'HomeController@send_email');

Route::get('frankie', function()
{
	return "welcome aboard";
});

Route::group(array('before'=>'auth'), function()
{
	Route::get('problem/new', 'ProblemController@new_problem_view');
	Route::post('problem/new', 'ProblemController@new_problem');

	Route::post('post-solution/{problem_id}', 'SolutionController@solution_post');

	Route::post('update-solution/{problem_id}', 'SolutionController@solution_update');

	Route::post('post-comment/{problem_id}/{solution_id}', 'CommentController@post_comment');
});

Route::get('about', 'HomeController@display_about');

Route::get('view-problem/{problem_id}', 'ProblemController@view_problem');

Route::post('view-problem/problem/views', 'ProblemController@count_views');

Route::get('all-problems', 'ProblemController@all_problems');
Route::post('all-problems', 'ProblemController@all_problems');



Route::get('login', 'AuthController@get_login_form')->before('guest');
Route::post('login', 'AuthController@post_login');

Route::get('signup', 'AuthController@create_account_view');
Route::post('signup', 'AuthController@create_account');

Route::get('logout', 'AuthController@logout');

Route::post('delete-solution', 'SolutionController@delete_solution');

Route::post('view-problem/solution/reliable', 'SolutionController@reliable');
Route::post('view-problem/solution/unreliable', 'SolutionController@unreliable');

Route::get('test', 'HomeController@test');


Validator::extend('menu_selected', function($attribute, $value, $parameters)
{
 if (intval($parameters[0]) > 0) 
 {
 	return true;
 } 
 else 
 {
 	return false;
 }
 
});