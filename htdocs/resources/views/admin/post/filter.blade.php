@extends('admin')

@section('content')

  <h3>Viewing category: {{ ucfirst($category) }}</h3>
  @if (count($posts) === 0)
    <p>No posts found for {{ ucfirst($category) }}.</p>
  @else
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <td>Post</td>
          <td>Created</td>
          <td>Clicks</td>
          <td>Active</td>
          <td>Actions</td>
        </tr> 
      </thead>
      @foreach($posts as $key => $value)
        <tr data-type="post" data-id="{{ $value->id }}" data-text="{{ substr($value->text, 0, 50) }}">
          <td>{{ $value->text }}</td>
          <td>{{ date('d/m/Y', strtotime($value->created_at)) }}</td>
          <td>{{ rand(1,100) }}</td>
          <td><input data-ajax="update-active" type="checkbox" checked></td>
          <td>
            <a class="btn btn-primary" href="{{ URL::route('admin.post.show', [$value->id]) }}">View</a>
            <a data-ajax="delete" class="btn btn-default">Delete</a>
          </td>
        </tr>
      @endforeach
    </table>
  @endif
  <div class="pull-right">
    <a class="btn btn-default" href="{{ route('admin.post.index') }}">View all posts</a>
    <a class="btn btn-default" data-ajax="filter">Filter by category</a>
    <a class="btn btn-default" href="{{ URL::route('admin.post.create') }}">Create new post</a>
  </div>
@endsection
