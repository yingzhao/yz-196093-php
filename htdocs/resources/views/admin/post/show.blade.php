@extends('admin')

@section('content')
  <h3>Viewing post</h3>

  <div class="row">
    <div class="col-md-6">

      <fieldset>
        <div class="form-group">
          <label class="control-label" for="text">Post text</label>                  
          {!! Form::textarea('text', $post->text, ['id' => 'postText', 'class' => 'form-control', 'disabled']) !!}
        </div>
        
        <div class="form-group">
          <label class="control-label">Using an image</label>        
          <div class="panel panel-default">
            <div class="panel-body">
              <p>{!! ($post->image != 'false' ? '<img src="' . $post->image . '">' : 'No image') !!}</p>
              <p>Chosen image link:</p>
              <textarea name="imageUrl" id="liveurl-selected" class="form-control" readonly="readonly">{!! (isset($post) && $post->image != 'false' ? $post->image : '') !!}</textarea>
            </div>
          </div> 
        </div>

        <div class="form-group">
          <label class="control-label" for="category">Post category</label> 
          <div class="input-group">
            {!! Form::text('category', ucfirst($post->category->name), ['class' => 'form-control', 'disabled']) !!}
          </div>
        </div>

        <div class="form-group">
          <label class="control-label" for="active">Active</label> 
          <div class="input-group">
            {!! Form::text('active', ucfirst($post->active), ['class' => 'form-control', 'disabled']) !!}
          </div>
        </div>

        <hr>

        <div class="form-group">
          <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-sml btn-primary">Edit post</a>
        </div>

      </fieldset>
    </div>
  </div>
@endsection
