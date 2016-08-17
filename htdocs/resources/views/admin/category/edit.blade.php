@extends('admin')

@section('content')
  <h3>Editing category: {{ ucfirst($category->name) }}</h3>

  <div class="row">
    <div class="col-md-6">
      {!! Form::model($category, array('method' => 'PUT', 'route' => array('admin.category.update', $category->id))) !!} 
        {!! View::make('admin.category._form') !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection
