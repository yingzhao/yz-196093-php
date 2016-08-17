@extends('admin')

@section('content')
  <h3>Viewing all categories</h3>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <td>Category</td>
        <td>Colour</td>
        <td>Posts</td>
        <td>Actions</td>
      </tr> 
    </thead>
    @foreach($categories as $key => $value)
      <tr data-type="category" data-id="{{ $value->id }}" data-text="{{ substr($value->name, 0, 50) }}">
        <td>{{ ucfirst($value->name) }}</td>
        <td><a class="btn" style="color: white; background-color: {{ $value->colour }}">{{ $value->colour }}</a></td>
        <td>
          <?php

            if ($value->postCount['aggregate'] == 1) { 
              echo '<a class="btn btn-default" href="' . route('admin.post.filter', $value->name) . '">';
              echo 'View posts within ' . ucfirst($value->name) . ' - '; 
              echo $value->postCount['aggregate'] . ' post';
              echo '</a>';
            } else if ($value->postCount['aggregate'] >= 2) { 
              echo '<a class="btn btn-default" href="' . route('admin.post.filter', $value->name) . '">';
              echo 'View posts within ' . ucfirst($value->name) . ' - '; 
              echo $value->postCount['aggregate'] . ' posts';
              echo '</a>';
            }

          ?>
        </td>
        <td>
          <a class="btn btn-primary" href="{{ URL::route('admin.category.edit', [$value->id]) }}">Edit</a>
          <a data-ajax="delete" class="btn btn-default">Delete</a>
        </td>
      </tr>
    @endforeach
  </table>
  <div class="pull-right">
    <a class="btn btn-default" href="{{ URL::route('admin.category.create') }}">Create new category</a>
  </div>
@endsection
