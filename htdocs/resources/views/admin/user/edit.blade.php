@extends('admin')

@section('content')
  <h3>Editing user</h3>
  @if (Auth::id() != $user->id)
    <p>You are editing another user's profile. Any changes you make to the below settings will affect them.</p>
  @endif

  <div class="row">
    <div class="col-md-6">
      {!! Form::model($user, array('method' => 'PUT', 'route' => array('admin.user.update', $user->id))) !!} 
        {!! View::make('admin.user._form')->with('user', $user) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection
