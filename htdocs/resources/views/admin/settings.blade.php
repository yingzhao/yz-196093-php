@extends('admin')

@section('content')
  <h3>Settings</h3>

  <div class="row">
    <div class="col-md-6">
      {!! Form::open(array('method' => 'PUT', 'route' => array('admin.settings.update',))) !!}
        <fieldset>
          <div class="form-group">
            @foreach($settings as $key => $value)
              <div class="form-group">
                <label class="control-label" for="body">{{ $value->name }}</label>
                <div class="input-group">

                  @if ($value->type == 'text')
                    <input name="{{ $value->key }}" type="text" class="form-control" value="{{ $value->value }}">
                  @endif

                  @if ($value->type == 'integer')
                    <input name="{{ $value->key }}" type="number" class="form-control" value="{{ $value->value }}">
                  @endif

                  @if ($value->type == 'boolean')
                    <input name="{{ $value->key }}Switch" type="checkbox" {!! ($value->value == 'true' ? 'checked' : '') !!}>
                    {!! Form::hidden('randomise', ($value->value == 'true' ? 'true' : 'false')) !!}
                  @endif

                </div>
                <span class="help-block">{{ $value->description }}</span>
              </div>
            @endforeach

            <hr>
            <div class="form-group">
              {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
            </div>

          </div>
        </fieldset>
      {!! Form::close() !!}
    </div>
  </div>
@endsection
