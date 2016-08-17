<fieldset>
  
  <div class="form-group">
    <label class="control-label" for="name">Name</label> 
    <div class="input-group">
      {!! Form::text('name', Input::old('name'), ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label" for="email">Email</label> 
    <div class="input-group">
      {!! Form::email('email', Input::old('email'), ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label" for="password">Password</label> 
    <div class="input-group">
      {!! Form::password('password', Input::old('password'), ['class' => 'form-control']) !!}
    </div>
  </div>

  <hr>

  <div class="form-group">
    {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
  </div>

</fieldset>