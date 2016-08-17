@extends('admin')

@section('content')
  <h3>Viewing all posts</h3>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <td>Post</td>
        <td>Category</td>
        <td>Created</td>
        <td>Image</td>
        <td>Active</td>
        <td>Actions</td>
      </tr> 
    </thead>
    @foreach($posts as $key => $value)
      <tr data-type="post" data-id="{{ $value->id }}" data-text="{{ substr($value->text, 0, 50) }}">
        <td>{{ $value->text }}</td>
        <td>{{ ucfirst($value->category->name) }}</td>
        <td>{{ date('d/m/Y', strtotime($value->created_at)) }}</td>
        <td>{{ $value->image != 'false' ? 'Yes' : 'No' }}</td>
        <td><input data-ajax="update-active" type="checkbox" {{ ($value->active == 'true' ? 'checked' : '') }}></td>
        <td>
          <a class="btn btn-primary" href="{{ URL::route('admin.post.show', [$value->id]) }}">View</a>
          <a data-ajax="delete" class="btn btn-default">Delete</a>
        </td>
      </tr>
    @endforeach
  </table>
  <div class="pull-right">
    <a class="btn btn-default" href="{{ route('admin.post.index') }}">View all posts</a>
    <a class="btn btn-default" data-ajax="filter">Filter by category</a>
    <a class="btn btn-default" href="{{ route('admin.post.create') }}">Create new post</a>
  </div>
@endsection
