@extends('admin')

@section('content')
  <h3>Create new user</h3>

  <div class="col-md-6">
    {!! Form::open(array('route' => 'admin.user.store', 'class' => 'form-horizontal')) !!}
      {!! View::make('admin.user._form') !!}
    {!! Form::close() !!}
  </div>
@endsection
