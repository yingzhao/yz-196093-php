@extends('admin')

@section('content')
  <h3>Editing post</h3>

  <div class="row">
    <div class="col-md-6">
      {!! Form::model($post, array('method' => 'PUT', 'route' => array('admin.post.update', $post->id))) !!} 
        {!! View::make('admin.post._form')->with(compact('post', 'categories')) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection
