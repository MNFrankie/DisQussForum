<?php

class ProblemController extends BaseController {
	
	public function new_problem_view()
	{
		$categoryList = DB::table('categories')->select('id','name')->get();
		$categories = array('empty' =>'Select Categories' );

		foreach ($categoryList as $category) 
		{
			$categories[$category->id] = $category->name;
		}

		$academicSemList = DB::table('academic_semesters')->select('id','academic_year','semester')->get();
		$academicSem = array('empty' =>'Select academic semester' );

		foreach ($academicSemList as $academic) 
		{
			$academicSem[$academic->id] = $academic->academic_year.'- Semester '.$academic->semester ;
		}		

		return View::make('new-problem')
					->with('academicSem', $academicSem)
					->with('categories', $categories);
	}

	public function new_problem()
	{
		$rules = array(
				'problem' => 'required',
				'category' => 'required|menu_selected:'.Input::get('category'),
				'academic-semester' => 'required|menu_selected:'.Input::get('academic-semester'),
			);
		$messages = array(
					'category.menu_selected' => 'Category MUST be selected.',
					'academic-semester.menu_selected' => 'Academic Semester MUST be selected.'
			);

		$validated = Validator::make(Input::all(), $rules, $messages);

		

		if ($validated->fails()) 
		{
			return Redirect::to('problem/new')
							->withInput()
							->withErrors($validated);
		}

		$problem =  preg_replace('/\s+/', ' ', Input::get('problem'));
		$solution_description = trim( Input::get('solution') );

		$cat_id = Input::get('category');
		$solution = Input::get('academic-semester');

		$new_problem = new Problem();
		$new_problem->description = $problem;
		$new_problem->user_id = Auth::user()->id;
		$new_problem->academic_semester_id = Input::get('academic-semester');
		$new_problem->save();

		if ($new_problem->save()) 
		{
			$category_prob = new CategoryProblem();
			$category_prob->category_id = $cat_id;
			$category_prob->problem_id = $new_problem->id;
			$category_prob->save();

			if ($category_prob->save()) 
			{
				if (Input::has('solution')) 
				{
					$new_solution = new Solution();
					$new_solution->description = $solution_description;
					$new_solution->problem_id = $new_problem->id;
					$new_solution->user_id = Auth::user()->id;
					$new_solution->save();
				}


				return Redirect::to('all-problems')->with('flash_info', 'Problem description successfully shared');
			}
		}
	
	}

	public function view_problem($problem_id)
	{
		$problem = Problem::find($problem_id);

		$solutions = Solution::where('problem_id', '=', $problem_id)->orderBy('created_at', 'desc')->get();

		$comments = DB::table('comments')
						->leftJoin('solutions', 'solutions.id','=', 'comments.solution_id')
						->leftJoin('problems', 'solutions.problem_id', '=', 'Problems.id')
						->where('solutions.problem_id', '=', $problem_id)
						->where('problems.id', '=', $problem_id)
						->select('comments.description','solutions.id as solution_id', 'comments.id')
						->get();

		return View::make('view-problem')
					->with('comments', $comments)
					->with('solutions', $solutions)
					->with('problem_id', $problem_id)
					->with('problem', $problem);
	}

	public function all_problems()
	{

		if (intval(Input::get('category')) > 0 || intval(Input::get('academic-semester')) > 0) 
		{
			$cat_id = Input::get('category');
			$sem = Input::get('academic-semester');
			

			if (intval(Input::get('category')) > 0 && intval(Input::get('academic-semester')) > 0) 
			{
				$all_prob = DB::table('problems')
									->join('users', 'users.id', '=', 'problems.user_id')
									->join('category_problem', 'category_problem.problem_id', '=', 'problems.id')
									->where('problems.academic_semester_id', $sem)
									->where('category_problem.category_id', $cat_id)
									->select('problems.id', 'problems.description', 'problems.created_at', 'users.name')
									->orderBy('problems.created_at', 'DESC')
									->paginate(3);
			}
			else if (intval(Input::get('category')) > 0 || intval(Input::get('academic-semester')) > 0)
			{
				$all_prob = DB::table('problems')
									->join('users', 'users.id', '=', 'problems.user_id')
									->join('category_problem', 'category_problem.problem_id', '=', 'problems.id')
									->orWhere('problems.academic_semester_id', isset($sem) ? $sem : false)
									->orWhere('category_problem.category_id', isset($cat_id) ? $cat_id : false)
									->select('problems.id', 'problems.description', 'problems.created_at', 'users.name')
									->orderBy('problems.created_at', 'DESC')
									->paginate(3);
			}
			

			$categoryList = DB::table('categories')->select('id','name')->get();
			$categories = array('empty' =>'Select Categories' );

			foreach ($categoryList as $category) 
			{
				$categories[$category->id] = $category->name;
			}

			$academicSemList = DB::table('academic_semesters')->select('id','academic_year','semester')->get();
			$academicSem = array('empty' =>'Select academic semester' );

			foreach ($academicSemList as $academic) 
			{
				$academicSem[$academic->id] = $academic->academic_year.'- Semester '.$academic->semester ;
			}

			/*Get Category Name and Semester Name*/
			$name = null;
			$semester = null;
			if (intval($cat_id) > 0 || intval($sem) > 0) 
			{
				if (intval($cat_id) > 0) 
				{
					$cat_name = Category::where('id', $cat_id)->first(array('name'));
					$name = $cat_name->name;
				}

				if (intval($sem) > 0) 
				{
					$sem_name = AcademicSemester::where('id', $sem)->first(array('academic_year','semester'));
					$semester = $sem_name->academic_year.'- Semester '.$sem_name->semester;
				}
			}
			/*End Here*/

			

			return View::make('all-problems')
						->with('cat_id', $cat_id)
						->with('sem', $sem)
						->with('category', $name)
						->with('academic_semester', $semester)
						->with('academicSem', $academicSem)
						->with('categories', $categories)
						->with('all_prob', $all_prob);
					
		}
		else
		{
			$all_prob = Problem::join('users', 'users.id', '=', 'problems.user_id')
								->select('problems.id', 'problems.description', 'problems.created_at', 'users.name')
								->orderBy('created_at', 'DESC')
								->paginate(3);

			$categoryList = DB::table('categories')->select('id','name')->get();
			$categories = array('empty' =>'Select Categories' );

			foreach ($categoryList as $category) 
			{
				$categories[$category->id] = $category->name;
			}

			$academicSemList = DB::table('academic_semesters')->select('id','academic_year','semester')->get();
			$academicSem = array('empty' =>'Select academic semester' );

			foreach ($academicSemList as $academic) 
			{
				$academicSem[$academic->id] = $academic->academic_year.'- Semester '.$academic->semester ;
			}


			return View::make('all-problems')
						->with('academicSem', $academicSem)
						->with('categories', $categories)
						->with('all_prob', $all_prob);
		}
	}

	public function get_specific_problems()
	{
		$cat_id = Input::get('category');
		$sem = Input::get('academic-semester');

		$all_prob = DB::table('problems')
								->join('users', 'users.id', '=','problems.user_id')
								->join('category_problem', 'category_problem.problem_id', '=', 'problems.id')
								->where('problems.academic_semester_id', $sem)
								->where('category_problem.category_id', $cat_id)
								->select('problems.id', 'problems.description', 'problems.created_at', 'users.name')
								->orderBy('problems.created_at', 'DESC')
								->get();

		$categoryList = DB::table('categories')->select('id','name')->get();
		$categories = array('empty' =>'Select Categories' );

		foreach ($categoryList as $category) 
		{
			$categories[$category->id] = $category->name;
		}

		$academicSemList = DB::table('academic_semesters')->select('id','academic_year','semester')->get();
		$academicSem = array('empty' =>'Select academic semester' );

		foreach ($academicSemList as $academic) 
		{
			$academicSem[$academic->id] = $academic->academic_year.'- Semester '.$academic->semester ;
		}

		return View::make('all-problems')
					->with('academicSem', $academicSem)
					->with('categories', $categories)
					->with('all_prob', $all_prob);
	}

	public function count_views()
	{
		$json = array(
				'success' => false,
			);

		$view = Problem::where('id', '=', Input::get('problem_id'))
					->first();
		$view->views = $view->views + 1;
		$view->save();

		if ($view->save()) 
		{
			$json['success'] = true;
			$json['views'] = $view->views;

			return json_encode($json);
		}
	}

	
}