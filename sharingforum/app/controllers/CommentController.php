<?php

class CommentController extends BaseController
{

	public function post_comment($problem_id, $solution_id)
	{
		$new_comment = new Comment();
		$new_comment->description = Input::get('comment');
		$new_comment->user_id = Auth::user()->id;
		$new_comment->solution_id = $solution_id;
		$new_comment->save();

		if ($new_comment->save()) 
		{
			return Redirect::to('view-problem/'.$problem_id);
		}
	}
}