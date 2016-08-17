@extends('admin')

@section('content')
  <h3>Create new post</h3>

  <div class="col-md-6">
    {!! Form::open(array('route' => 'admin.post.store', 'class' => 'form-horizontal')) !!}
      {!! View::make('admin.post._form')->with('categories', $categories) !!}
    {!! Form::close() !!}
  </div>
@endsection
