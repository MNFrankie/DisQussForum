@extends('templates.master')

@section('title')
All Problems
@endsection

@section('all-problem-style')
<style>
	.problem
	{
		margin-bottom: 40px;
		padding-bottom: 40px;
		border-bottom: 1px dashed #DDD;
	}
</style>
@endsection

@section('contents')
	<div class="col-sm-12" style="margin-top:20px; border:2px solid #ccc; padding:15px; border-radius:5px; margin-bottom:50px">
		{{ Form::open(array('url'=>'all-problems', 'method'=>'post')) }}
			<div class="row">
				<div class="col-sm-4">
					<h4> Choose Category </h4>
				</div>
				<div class="col-sm-5 col-sm-offset-1">
					{{ Form::select('category', $categories, isset($cat_id) ? $cat_id : "empty",array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<h4> Choose Academic Semester </h4>
				</div>
				<div class="col-sm-5 col-sm-offset-1">
					{{ Form::select('academic-semester', $academicSem, isset($sem) ? $sem : "empty",array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="col-sm-10">
				{{ Form::submit('GO', array('class'=>'btn btn-info btn-sm pull-right')) }}
			</div>
		{{ Form::close() }}
	</div>
	<hr>
	<br><br>
	<div class="col-lg-12"></div>
	<div class="row">
		@if(Session::has('flash_info'))
	<div class="alert alert-success fade in" style="border: 1px solid #DDD; display: inline-block;">
	 <button class="close" data-dismiss="alert" type="button"><i class="icon-remove"></i></button>
	 <h4 class="alert-heading">Successfully shared!</h4>
	 {{ Session::get('flash_info') }}
	</div>
	@endif
	</div>
	@foreach($all_prob as $problem)

		<div class="problem">
			<div class="row">
				{{ $problem->description }}
			</div>
			<div class="row">posted by: {{ $problem->name }} @ {{ date('jS F Y', strtotime($problem->created_at))}}</div>

			<div class="row"></div>
			<div class="row">
				<a href="{{ URL::to('view-problem/'.$problem->id) }}" class="btn btn-info btn-sm">View More</a>
			</div>
		</div>
	@endforeach

	<ul class="pagination">
		{{ $all_prob->links() }}
	</ul>
@endsection
