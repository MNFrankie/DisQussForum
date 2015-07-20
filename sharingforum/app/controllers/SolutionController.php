<?php

class SolutionController extends BaseController
{
	public function solution_post($problem_id)
	{
		$new_solution = new Solution();
		$new_solution->description = Input::get('solution');
		$new_solution->problem_id = $problem_id;
		$new_solution->user_id = Auth::user()->id;
		$new_solution->save();

		if ($new_solution->save()) 
		{
			return Redirect::to('view-problem/'.$problem_id);
		}
	}

	public function delete_solution()
	{
		$json = array('success'=> false, "solution_id"=>Input::get('solution_id'));

		if (Comment::where('solution_id', '=', intval(Input::get('solution_id')))->count() > 0) 
		{
			$deleted = Comment::where('solution_id', '=', intval(Input::get('solution_id')))->delete();

			if ($deleted) 
			{
				$soln_deleted = Solution::where('id', '=', intval(Input::get('solution_id')))->delete();

				if ( $soln_deleted ) 
				{
					$json['success'] = true;
					$json['solution_id'] = Input::get('solution_id');
				}
			}
		}
		else
		{
			$soln_deleted = Solution::where('id', '=', intval(Input::get('solution_id')))->delete();

				if ( $soln_deleted ) 
				{
					$json['success'] = true;
					$json['solution_id'] = Input::get('solution_id');
				}
		}

		return Response::json($json);
	}

	public function solution_update($problem_id)
	{
		$update_solution = Solution::where('id', '=', Input::get('solnID'))->first();
		$update_solution->description = Input::get('editSoln');
		$update_solution->save();

		if ( $update_solution->save() ) 
		{
			return Redirect::to('view-problem/'.$problem_id)->with('flash_info', 'Your solution has been successfully edited!.');
		}
	}

	public function reliable()
	{
		$json = array(
				'success' => false
			);

		if (Auth::check()) 
		{
			$has_rated = Reliability::where('solution_id', '=', Input::get('solution_id'))
									->where('user_id', '=', Auth::user()->id)
									->count();

			if ($has_rated > 0) 
			{
				$json['feedback'] = 'You cannot rate twice';

				return json_encode($json);
			}
			else
			{
				$reliable = Solution::where('id', '=', Input::get('solution_id'))
								->first();
				$reliable->reliable = $reliable->reliable + 1;
				$reliable->save();

				if ($reliable->save()) 
				{
					$add_reliability = new Reliability();
					$add_reliability->user_id = Auth::user()->id;
					$add_reliability->solution_id = Input::get('solution_id');
					$add_reliability->reliability = 1;
					$add_reliability->save();

					if ($add_reliability->save()) 
					{
						$json['success'] = true;
						$json['reliable'] = $reliable->reliable;
						$json['unreliable'] = $reliable->unreliable;

						return json_encode($json);
					}
				}
			}
		}
		else
		{
			$json['feedback'] = 'Must be logged in first';

			return json_encode($json);
		}
	}

	public function unreliable()
	{
		$json = array(
				'success' => false
			);

		if (Auth::check()) 
		{
			$has_rated = Reliability::where('solution_id', '=', Input::get('solution_id'))
									->where('user_id', '=', Auth::user()->id)
									->count();

			if ($has_rated > 0) 
			{
				$json['feedback'] = 'You cannot rate twice';

				return json_encode($json);
				
			}
			else
			{
				$reliable = Solution::where('id', '=', Input::get('solution_id'))
								->first();
				$reliable->unreliable = $reliable->unreliable + 1;
				$reliable->save();

				if ($reliable->save()) 
				{
					$add_reliability = new Reliability();
					$add_reliability->user_id = Auth::user()->id;
					$add_reliability->solution_id = Input::get('solution_id');
					$add_reliability->reliability = 0;
					$add_reliability->save();

					if ($add_reliability->save()) 
					{
						$json['success'] = true;
						$json['reliable'] = $reliable->reliable;
						$json['unreliable'] = $reliable->unreliable;

						return json_encode($json);
					}
				}
			}
		}
		else
		{
			$json['feedback'] = 'Must be logged in first';

			return json_encode($json);
		}
	}

	/*public function reliable_unreliable()
	{
		$json = array(
				'success' => false
			);

		$solution_id = 0;

		if (Input::get('reliabilityType') == 1) 
		{
			$solution_id = Input::get('reliable_solution');
		}
		else if(Input::get('reliabilityType') == 0)
		{
			$solution_id = Input::get('unreliable_solution');
		}
		
		if (Auth::check()) 
		{
			$has_rated = Reliability::where('solution_id', '=', $solution_id)
									->where('user_id', '=', Auth::user()->id)
									->count();
			
			if ($has_rated >0) 
			{
				$reliability_value = Reliability::where('solution_id', '=', $solution_id)
												->where('user_id', '=', Auth::user()->id)
												->first()->reliability;

				if (Input::get('reliabilityType') == 0) 
				{
					if ($reliability_value == 0) 
					{
						$json['feedback'] = 'You cannot rate twice';

						return json_encode($json);
					}
					else if ($reliability_value == 1)
					{
						$reliable = Solution::find($solution_id);
						$reliable->reliable = $reliable->reliable - 1;
						$reliable->unreliable = $reliable->unreliable + 1;
						$reliable->save();

						if ($reliable->save()) 
						{
							$json['success'] = true;
							$json['unreliable'] = $reliable->unreliable;
							$json['reliable'] = $reliable->reliable;

							return json_encode($json);
						}
					}
				}
				else if (Input::get('reliabilityType') == 1) 
				{
					if ($reliability_value > 0) 
					{
						$json['feedback'] = 'You cannot rate twice';

						return json_encode($json);
					}
					else
					{
						$reliable = Solution::find($solution_id);
						$reliable->reliable = $reliable->reliable + 1;
						$reliable->unreliable = $reliable->unreliable - 1;
						$reliable->save();

						if ($reliable->save()) 
						{
							$json['success'] = true;
							$json['unreliable'] = $reliable->unreliable;
							$json['reliable'] = $reliable->reliable;

							return json_encode($json);
						}
					}
				}
			}
			else
			{
				if (Input::get('reliabilityType') == 1) 
				{
					$reliable = Solution::where('id', '=', $solution_id)
								->first();
					$reliable->reliable = $reliable->reliable + 1;
					$reliable->save();

					if ($reliable->save()) 
					{
						$add_reliability = new Reliability();
						$add_reliability->user_id = Auth::user()->id;
						$add_reliability->solution_id = $solution_id;
						$add_reliability->reliability = 1;
						$add_reliability->save();

						if ($add_reliability->save()) 
						{
							$json['success'] = true;
							$json['reliable'] = $reliable->reliable;
							$json['unreliable'] = $reliable->unreliable;

							return json_encode($json);
						}
					}
					
				}
				else if (Input::get('reliabilityType') == 0) 
				{
					$unreliable = Solution::where('id', '=', $solution_id)
											->first();
					$unreliable->unreliable = $unreliable->unreliable + 1;
					$unreliable->save();

					if ($unreliable->save()) 
					{
						$add_reliability = new Reliability();
						$add_reliability->user_id = Auth::user()->id;
						$add_reliability->solution_id = $solution_id;
						$add_reliability->reliability = 0;
						$add_reliability->save();

						if ($add_reliability->save()) 
						{
							$json['success'] = true;
							$json['unreliable'] = $unreliable->unreliable;
							$json['reliable'] = $unreliable->reliable;

							return json_encode($json);
						}
					}
				}

			}
									
			
		}
		else
		{
			$json['feedback'] = 'Must be logged in first';

			return json_encode($json);
		}		
	}*/

	/*public function reliable_unreliable($reliable, $problem_id, $solution_id)
	{
		
		if (Auth::check()) 
		{
			$has_rated = Reliability::where('solution_id', '=', $solution_id)
									->where('user_id', '=', Auth::user()->id)
									->count();
			
			if ($has_rated >0) 
			{
				$reliability_value = Reliability::where('solution_id', '=', $solution_id)
												->where('user_id', '=', Auth::user()->id)
												->first()->reliability;

				if ($reliable == 0) 
				{
					if ($reliability_value == 0) 
					{
						return Redirect::to('view-problem/'.$problem_id);
					}
					else if ($reliability_value == 1)
					{
						$reliable = Solution::find($solution_id);
						$reliable->reliable = $reliable->reliable - 1;
						$reliable->unreliable = $reliable->unreliable + 1;
						$reliable->save();

						if ($reliable->save()) 
						{
							return Redirect::to('view-problem/'.$problem_id);
						}
					}
				}
				else if ($reliable == 1) 
				{
					if ($reliability_value > 0) 
					{
						return Redirect::to('view-problem/'.$problem_id);
					}
					else
					{
						$reliable = Solution::find($solution_id);
						$reliable->reliable = $reliable->reliable + 1;
						$reliable->unreliable = $reliable->unreliable - 1;
						$reliable->save();

						if ($reliable->save()) 
						{
							return Redirect::to('view-problem/'.$problem_id);
						}
					}
				}
			}
			else
			{
				if ($reliable == 1) 
				{
					$reliable = Solution::where('id', '=', $solution_id)
								->first();
					$reliable->reliable = $reliable->reliable + 1;
					$reliable->save();

					if ($reliable->save()) 
					{
						$add_reliability = new Reliability();
						$add_reliability->user_id = Auth::user()->id;
						$add_reliability->solution_id = $solution_id;
						$add_reliability->reliability = 1;
						$add_reliability->save();

						if ($add_reliability->save()) 
						{
							return Redirect::to('view-problem/'.$problem_id);
						}
					}
					
				}
				else if ($reliable == 0) 
				{
					$unreliable = Solution::where('id', '=', $solution_id)
											->first();
					$unreliable->unreliable = $unreliable->unreliable + 1;
					$unreliable->save();

					if ($unreliable->save()) 
					{
						$add_reliability = new Reliability();
						$add_reliability->user_id = Auth::user()->id;
						$add_reliability->solution_id = $solution_id;
						$add_reliability->reliability = 0;
						$add_reliability->save();

						if ($add_reliability->save()) 
						{
							return Redirect::to('view-problem/'.$problem_id);
						}
					}
				}

			}
									
			
		}
		else
		{
			return Redirect::to('view-problem'.$problem_id);
		}		
	}*/
}