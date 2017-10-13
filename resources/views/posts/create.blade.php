@extends('layouts.app')

@section('title', ' | Create New Post')

@section('content')
<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
        toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        encoding: "xml"
    });

</script>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Create New Post</h1>
			<hr>
			{{ Form::open(array('route'=>'posts.store')) }}
			<div class="form-group">
				{{ Form::label('title', 'Title') }}
				{{ Form::text('title',null,array('class'=>'form-control')) }}
				<br>

				{{ Form::label('body','Post Body') }}
				{{ Form::textarea('body',null,array('class'=>'form-control')) }}
				<br>

				{{ Form::submit('Create Post',array('class'=>'btn btn-success btn-lg btn-block')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
@endsection