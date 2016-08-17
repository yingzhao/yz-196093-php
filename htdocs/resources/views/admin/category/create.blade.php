@extends('admin')

@section('content')
  <h3>Create new category</h3>

  <div class="col-md-6">
    {!! Form::open(array('route' => 'admin.category.store', 'class' => 'form-horizontal')) !!}
      {!! View::make('admin.category._form') !!}
    {!! Form::close() !!}
  </div>
@endsection
