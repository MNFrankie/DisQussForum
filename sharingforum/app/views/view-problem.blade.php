@extends('templates.master')

@section('title')
View Problem
@endsection

@section('problem-style')
<link rel="stylesheet" href="{{ URL::to('bootstrap/css/jquery.gritter.css') }}">
<style>
	.management-btn-holder
	{
		position: absolute;
		top: 0;
		right: 0;
	}
	
	.solution-description
	{
		position: relative;
	}

	.problem
	{
		margin-bottom: 40px;
		padding-bottom: 40px;
		border-bottom: 1px dashed #DDD;
	}

	.badge.bg-success 
	{
    	background: none repeat scroll 0% 0% #A9D86E;
	}

	.badge.bg-warning 
	{
    	background: none repeat scroll 0% 0% #FCB322;
	}
</style>
@endsection

@section('contents')
<div class="row">
	@if(Session::has('flash_info'))
	<div class="alert alert-success fade in" style="border: 1px solid #DDD;">
	 <button class="close" data-dismiss="alert" type="button"><i class="icon-remove"></i></button>
	 <h4 class="alert-heading">Solution Updated!</h4>
	 {{ Session::get('flash_info') }}
	</div>
	@endif
</div>
<div class="row">
	<div class="problem" id="problem">
		<div class="col-sm-5">
			{{ $problem->description }}
		</div>

		<div class="col-sm-5 pull-right">
			<span class="badge bg-success" id="views">{{ $problem->views }}</span> <label for="">Views</label>
			{{ Form::hidden('views',$problem_id,array('id'=>'views-problem-id')) }}
		</div>
	</div>
</div>

@if(Auth::guest())
	<div class="row">
		@foreach($solutions as $solution)
			<div class="row">
				{{ $solution->description }}
			</div>
			<div class="row">
				<div class="col-sm-6 pull-right">
					<div class="col-sm-4"><span class="badge bg-success" id="reliable-{{ $solution->id }}">{{ $solution->reliable }}</span><a class="reliable" id="link-reliable-{{ $solution->id }}" href="">reliable</a></div>
					<div class="col-sm-4"><span class="badge bg-warning" id="unreliable-{{ $solution->id }}">{{ $solution->unreliable }}</span><a class="unreliable" id="unreliable-{{ $solution->id }}" href="">unreliable</a></div>
				</div>
			</div>
			
			@foreach($comments as $comment)
				@if($comment->solution_id == $solution->id)
				<div class="row">
					{{ $comment->description }} <br><hr>
				</div>
				@endif
			@endforeach
			
		@endforeach
	</div>
@else
	<div class="row">
	{{ Form::open(array('url'=>'post-solution/'.$problem_id)) }}
		<div class="col-sm-8">
			<p>Share Solution</p>
			<textarea name="solution" id="solution" cols="30" rows="20" class="form-control"></textarea>
		</div>
		<div class="col-sm-8">
			{{ Form::submit('Share Your Solution', array('class'=>'btn btn-primary btn-sm pull-right')) }}
		</div>
	{{ Form::close() }}
	</div>
	<div class="row">
		@foreach($solutions as $solution)
			<div id="parent-solution-{{ $solution->id }}">
				<div class="row solution-description">
					<div id="solution-description-{{ $solution->id }}">
						{{ $solution->description }}
					</div>
					

					@if ( $solution->user_id == Auth::user()->id )
						<div class="btn-group management-btn-holder" style="display: none;">
							<a href="" class="btn btn-default btn-xs soln-delete" id="soln-r-{{ $solution->id }}"><i class="glyphicon glyphicon-remove"></i> Delete</a>
							<a href="" class="btn btn-default btn-xs soln-edit" id="soln-e-{{ $solution->id }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
						</div>
					@endif
				</div>
				@if ( $solution->user_id == Auth::user()->id )
					<div class="row">
						<div class="col-sm-6 pull-right">
							<div class="col-sm-4"><span class="badge bg-success" id="reliable-{{ $solution->id }}">{{ $solution->reliable }}</span><a class="not-reliable" id="link-reliable-{{ $solution->id }}" href="">reliable</a></div>
							<div class="col-sm-4"><span class="badge bg-warning" id="unreliable-{{ $solution->id }}">{{ $solution->unreliable }}</span><a class="not-unreliable" id="unreliable-{{ $solution->id }}" href="">unreliable</a></div>
						</div>
					</div>
				@else
					<div class="row">
						<div class="col-sm-6 pull-right">
							<div class="col-sm-4"><span class="badge bg-success" id="reliable-{{ $solution->id }}">{{ $solution->reliable }}</span><a class="reliable" id="link-reliable-{{ $solution->id }}" href="">reliable</a></div>
							<div class="col-sm-4"><span class="badge bg-warning" id="unreliable-{{ $solution->id }}">{{ $solution->unreliable }}</span><a class="unreliable" id="unreliable-{{ $solution->id }}" href="">unreliable</a></div>
						</div>
					</div>
				@endif

				<a class="comment-avail" href="">Add Comment</a>
				<div class="row link-sibling">
				{{ Form::open(array('url'=>'post-comment/'.$problem_id.'/'.$solution->id)) }}
					<div class="col-sm-8 comment-section">
						<textarea name="comment" cols="30" rows="20"  class="comment form-control hide"></textarea>
					</div>
				{{ Form::close() }}
				</div>
				@foreach($comments as $comment)
					@if($comment->solution_id == $solution->id)
					<div class="row">
						{{ $comment->description }} <br><hr>
					</div>
					@endif
				@endforeach
			</div>
		@endforeach
	</div>
@endif
@endsection

@section('edit-solution-modal')
<!-- Modal -->
<div class="modal fade" id="edit-solution" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  	{{ Form::open(array('url'=>'update-solution/'.$problem_id)) }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Solution</h4>
      </div>
      <div class="modal-body">
        	<textarea name="editSoln" cols="30" rows="20" id="editSoln" class="editSoln form-control"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    {{ Form::hidden('solnID', '', array('id'=>'solnID')) }}
    {{ Form::close() }}
  </div>
</div>
@endsection
@section('view-problem-script')
<script src="{{ URL::to('bootstrap/js/jquery.gritter.min.js') }}"></script>
<script>
	$(function(){
		$('.solution-description').hover(
			function(){
				$(this).find('.management-btn-holder').show();
			},
			function(){
				$(this).find('.management-btn-holder').hide();
			}
		);

		$('#solution').redactor();

		$('#editSoln').redactor();

		$('.comment').redactor();
		$('div.comment-section div.redactor_box').removeClass('show').addClass('hide');

		$('a.comment-avail').on('click', function(e)
		{
			
			e.preventDefault();

			var that = this;

			if (($(that).next("div").find('div.comment-section div.redactor_box').hasClass('hide'))) 
			{
				$('div.comment-section div.redactor_box').removeClass('show').addClass('hide');
				$(that).next("div").find('div.comment-section div.redactor_box')
						.removeClass('hide')
						.addClass('show');
			}
			else
			{
				$(that).next("div").find('div.comment-section div.redactor_box').removeClass('show').addClass('hide');
			}
				
		});
		
		$('div.comment-section div.redactor_box').append('<input class="btn btn-info comment-btn" type="submit" value="Post Comment">')
		
		$('.soln-edit').on('click', function(e)
		{
			e.preventDefault();

			var btn = this.id;
			var index = btn.lastIndexOf("-");
			var btnID = btn.substring(index + 1);

			document.getElementById('solnID').value = btnID;

			var soltext = $('#solution-description-'+btnID).html();
			console.log(soltext);


			$('#edit-solution').modal();
			$('.redactor_editSoln').html(soltext);
		});

		$('.soln-delete').on('click', function(e)
		{
			e.preventDefault();

			var btn = this.id;
			var index = btn.lastIndexOf("-");
			var btnID = btn.substring(index + 1);

			var solnDeleted = $.ajax({
									type: "POST",
									cache: false,
									url: "{{ URL::to('delete-solution') }}",
									data: {
										solution_id : btnID
									}
								});

			solnDeleted.done(function(response)
				{
					console.log(response);
					$('#parent-solution-'+response.solution_id).detach();

					$.gritter.add({
			            // (string | mandatory) the heading of the notification
			            title: 'Solution Deleted!',
			            // (string | mandatory) the text inside the notification
			            text: "Solution has been deleted successfully. Note that comments under this solution are also deleted."
			        });
				});
		});

		//reliable and unreliable functionality
		//Reliable adding functionality
		$('a.reliable').on('click', function(e)
		{
			
			var that = this;
			var btn = that.id;
			var index = btn.lastIndexOf("-");
			var btnID = btn.substring(index + 1);
			
			$.ajax({
				type: "POST",
				cache: false,
				url: "solution/reliable",
				dataType: 'json',
				data: { solution_id: btnID},
				success: function(response)
				{
					if (response.success) 
					{
						$('span#unreliable-'+btnID).text(response.unreliable);
						$('span#reliable-'+btnID).text(response.reliable);
						console.log(response);
					}
					else
					{
						
						$.gritter.add({
				            // (string | mandatory) the heading of the notification
				            title: 'Sorry!',
				            // (string | mandatory) the text inside the notification
				            text: response.feedback
				        });
					}
				}
			});
			
			e.preventDefault();
		});

		$('a.not-reliable').on('click', function(e)
		{
			e.preventDefault();

			$.gritter.add({
	            // (string | mandatory) the heading of the notification
	            title: 'Rate Failed!',
	            // (string | mandatory) the text inside the notification
	            text: "You cannot rate your own solution."
	        });
		});

		//Unreliable adding functionality
		$('a.unreliable').on('click', function(e)
		{
			
			var that = this;
			var btn = that.id;
			var index = btn.lastIndexOf("-");
			var btnID = btn.substring(index + 1);
			
			$.ajax({
				type: "POST",
				cache: false,
				url: "solution/unreliable",
				dataType: 'json',
				data: { solution_id: btnID,},
				success: function(response)
				{
					if (response.success) 
					{
						$('span#unreliable-'+btnID).text(response.unreliable);
						$('span#reliable-'+btnID).text(response.reliable);
						console.log(response);
					}
					else
					{
						console.log(response.feedback);

						$.gritter.add({
				            // (string | mandatory) the heading of the notification
				            title: 'Sorry!',
				            // (string | mandatory) the text inside the notification
				            text: response.feedback
				        });
					}
				}
			});

			e.preventDefault();
		});

		$('a.not-unreliable').on('click', function(e)
		{
			e.preventDefault();

			$.gritter.add({
	            // (string | mandatory) the heading of the notification
	            title: 'Rate Failed!',
	            // (string | mandatory) the text inside the notification
	            text: "You cannot rate your own solution."
	        });
		});

		$.ajax({
			type: "POST",
			cache: false,
			url: "problem/views",
			dataType: 'json',
			data: { problem_id: $('#views-problem-id').val()},
			success: function(response)
			{
				if (response.success) 
				{
					$('#views').text(response.views);
				}
			}
		});
	});
</script>
@endsection