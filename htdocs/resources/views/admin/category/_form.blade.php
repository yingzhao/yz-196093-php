<fieldset>
  <div class="form-group">
    <label class="control-label" for="category">Category title</label>                  
    <div class="input-group">
      {!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label" for="colour">Tile colour</label> 
    <div class="input-group">
      {!! Form::text('colour', Input::old('colour'), array('class' => 'form-control')) !!}
    </div>
  </div>

  <hr>
  <div class="form-group">
    {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
  </div>

</fieldset>