@extends('admin')

@section('content')
  <h3>Welcome to the dashboard</h3>
  <p>What would you like to do?</p>
  <div class="col-md-12 moduleContainer">
    <div class="row">
      <a href="{{ route('admin.post.create') }}">
        <div class="col-md-6 module">
          <i class="fa fa-pencil-square-o fa-5x"></i>
          <h4>Create a new post</h4>
        </div>
      </a>
      <a href="{{ route('admin.post.index') }}">
        <div class="col-md-6 module">
          <i class="fa fa-inbox fa-5x"></i>
          <h4>View all posts</h4>
        </div>
      </a>
    </div>
  </div>
@endsection
