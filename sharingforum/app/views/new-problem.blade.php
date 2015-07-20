@extends('templates.master')

@section('title')
New Problem
@endsection
<link rel="stylesheet" href="{{ URL::to('bootstrap/css/jquery.gritter.css') }}">
@section('new-problem-style')
<style>
	@media (min-width: 768px) {
	  .container {
	    width: 550px;
	  }
	}
	@media (min-width: 992px) {
	  .container {
	    width: 800px;
	  }
	}
	@media (min-width: 1200px) {
	  .container {
	    width: 960px;
	  }
	}
</style>
@endsection
	

@section('contents')
	<div class="row">
		@if($errors->any())
		<div class="alert alert-block alert-danger fade in err list-unstyled" style="border: 1px solid #DDD;">
		 <button class="close" data-dismiss="alert" type="button"><i class="icon-remove"></i></button>
		 <h4 class="alert-heading">Oh snap! You got an error!</h4>
		 {{implode('', $errors->all('<li class="error">:message</li>'))}}
		</div>
		@endif
	</div>
	@if(Auth::guest())
		<div class="row">
			<p>You must be logged in to post a new problem. <a href="{{ URL::to('login') }}">Log In</a> </p>
		</div>
	@else
		{{ Form::open(array('id'=>'new-post-problem')) }}
			<div class="row">
				<div class="col-sm-8">
					<p>Problem description</p>
					<textarea name="problem" id="problem" cols="30" rows="20" class="problem form-control"> {{ Input::old('problem') }}</textarea>
				</div>
				<div class="col-sm-4">
					<div class="row">
						{{ Form::select('category', $categories, Input::old('category'),array('class'=>'form-control')) }}
					</div>
					<div class="row">
						{{ Form::select('academic-semester', $academicSem, Input::old('academic-semester'),array('class'=>'form-control')) }}
					</div>
				</div>
			</div>
			
			<div class="checkbox">
			    <label>
			       <input type="checkbox" name="solution-avail" id="solution-avail" class="solution-avail"> Check this if you have a solution
			    </label>
			</div>

			<div class="row">
				<div class="col-sm-8" id="solution-section">
					<textarea style="max-height:2em" name="solution" id="solution" cols="30" rows="5" class="form-control hide">{{ Input::old('solution') }}</textarea>
				</div>
			</div>
			<div class="col-sm-8">
				{{ Form::submit('Post Problem', array('class'=>'btn btn-primary btn-sm pull-right', 'id'=>'new-post-problem-btn')) }}
			</div>
		{{ Form::close() }}
	@endif
@endsection

@section('new-problem-script')
<script src="{{ URL::to('bootstrap/js/jquery.gritter.min.js') }}"></script>
<script>
	$(function(){
		
		$('#new-post-problem-btn').on('click', function(e)
			{
				e.preventDefault();

				if ( $('.redactor_problem').text().trim() != '' ) 
				{
					$('#new-post-problem').submit();
				}
				else
				{
					alert('Text area is empty');
				}
				
			});

		
		$('#problem').redactor();
		$('#solution').redactor();
		$('div#solution-section div.redactor_box').removeClass('show').addClass('hide');

		$('input#solution-avail').on('click', function()
		{
			if ($('input#solution-avail').prop('checked')) 
			{
				$('div#solution-section div.redactor_box').removeClass('hide').addClass('show');
			}
			else
			{
				$('div#solution-section div.redactor_box').removeClass('show').addClass('hide');
			}
		});
	});
</script>
@endsection
