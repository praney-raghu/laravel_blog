@extends('layouts.app')

@section('title', '| View Post')

@section('content')

<div class="container">
    
    <h1>{{ $post->title }}</h1>
    <hr>
    <div class="well" style="color: orange;"><p class="lead"><h4>{!! html_entity_decode($post->body) !!} </h4></p></div>
    @if($data!=NULL)
    @for(;$i>=0;$i--)
        <div class="panel panel-info" style="width:auto;">
            <div class="panel-heading"><b> {{ $data['name'][$i] }} </b> commented:</div>
            {!! Form::open(['method'=>'DELETE', 'route'=>['comments.destroy',$data['id'][$i]] ]) !!}            
            <div class="panel-body" style="height: auto;"> {{ $data['body'][$i] }} </div>
            @can('Delete Comment')
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            @endcan
            {!! Form::close() !!}
        </div>
    @endfor
    @endif
    @can('Comment')
    <button data-toggle="collapse" data-target="#demo" class="btn btn-primary" >Comment</button>
    {!! Form::open(array('route'=>'comments.store')) !!}
    {!! Form::hidden('id', $post->id) !!}
        <div id="demo" class="form-group collapse">
            <br>
            {{ Form::textarea('body',null,array('class'=>'form-control','rows' => 3, 'cols' => 30)) }}
            <br>
            {!! Form::submit('Save',array('class'=>'btn btn-success')) !!}
            {!! Form::close() !!}
        </div>
    @endcan
    <hr>
    {!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id] ]) !!}    
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @can('Edit Post')
    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info" role="button">Edit</a>
    @endcan
    @can('Delete Post')
    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
    @endcan
    {!! Form::close() !!}

</div>

@endsection