@extends('admin')

@section('content')
  <h3>Viewing all users</h3>
  <p>All users below are admin and can log-in and manage posts.</p>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <td>Name</td>
        <td>Email</td>
        <td>Actions</td>
      </tr> 
    </thead>
    @foreach($users as $key => $value)
      <tr data-type="user" data-id="{{ $value->id }}" data-text="{{ substr($value->name, 0, 50) }}">
        <td><img class="img-rounded" src="data:image/jpeg;base64,{{ $value->avatar }}"> {{ $value->name }}</td>
        <td>{{ $value->email }}</td>
        <td>
          <a class="btn btn-primary" href="{{ URL::route('admin.user.edit', [$value->id]) }}">Edit</a>
          <a data-ajax="delete" class="btn btn-default">Delete</a>
        </td>
      </tr>
    @endforeach
  </table>
  <div class="pull-right">
    <a class="btn btn-default" href="{{ route('admin.user.create') }}">Create new user</a>
  </div>
@endsection
