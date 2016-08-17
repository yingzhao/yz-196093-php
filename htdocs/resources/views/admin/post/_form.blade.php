<fieldset>
  <div class="form-group">
    <label class="control-label" for="text">Post text</label>                  
    {!! Form::textarea('text', Input::old('text'), ['id' => 'postText', 'class' => 'form-control']) !!}
    
    <p class="help-block"><span id="postCount">140 characters only.</span></p>
  </div>
  
  <div class="form-group">
    <label class="control-label" for="image">Use an image</label> 
    <div class="input-group">
      <input name="imageSwitch" type="checkbox" {!! (isset($post) && $post->image != 'false' ? 'checked' : '') !!}>
      {!! Form::hidden('image', Input::old('image')) !!}
    </div>
  </div>

  <div id="imgPanel" class="form-group">
    <div class="panel panel-default">
      <div class="panel-heading">
        <p>Please start your URL with 'www'</p>
        <div id="imageUrlContainer" class="input-group">
          <input id="imageUrlInput" placeholder="Enter URL to search" class="form-control" type="text">
          <span class="input-group-btn">
            <button id="imageUrlButton" class="btn btn-default" type="button">Go!</button>
          </span>
        </div>
        <a id="selectImage" class="btn btn-sml btn-primary">Select image for post</a>
      </div>
      <div class="panel-body">

        <div class="liveurl-loader"></div>
        
        <div class="liveurl">
          <div class="close" title="close"></div>
          <div class="inner">
            <div class="image"> </div>
            <div class="details">
              <div class="live-thumbnail">
                <div class="pictures">
                  <div class="controls">
                    <div class="prev button inactive"></div>
                    <div class="next button inactive"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <p>Chosen image link:</p>
        <textarea name="imageUrl" id="liveurl-selected" class="form-control" readonly="readonly">{!! (isset($post) && $post->image != 'false' ? $post->image : '') !!}</textarea>

      </div>
    </div> 
  </div>

  <div class="form-group">
    <label class="control-label" for="category">Post category</label> 
    <div class="input-group">
      {!! Form::select('category_id', $categories, Input::old('category_id'), ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label" for="active">Active</label> 
    <div class="input-group">
      <input name="activeSwitch" type="checkbox" {!! (isset($post) && $post->active == 'true' ? 'checked' : '') !!}>
      {!! Form::hidden('active', Input::old('active')) !!}
    </div>
  </div>

  <hr>

  <div class="form-group">
    {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
  </div>

</fieldset>

