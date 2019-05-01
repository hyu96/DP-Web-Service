@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Thêm hoạt động mới</h1>
@stop

@section('content')
  {!! Form::open(['url' => route('admin.news.store'), 'method' => 'post', 'files' => true]) !!}
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="form-group has-feedback {{ $errors->has('title') ? 'has-error' : '' }}">
          {{ Form::label('title', 'Nội dung hoạt động') }}
          {{ Form::textarea('title', old('title'), ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'rows' => 3]) }}
          @if ($errors->has('title'))
          <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
            </span>
          @endif
        </div>

        <div class="form-group has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
          {{ Form::label('image', 'Hình ảnh') }}
          {{ Form::file('image', ['required', 'accept' => 'image/x-png,image/gif,image/jpeg', 'id' => 'image']) }}
          <img id="previewImg" src=""/>
          @if ($errors->has('image'))
          <span class="help-block">
            <strong>{{ $errors->first('image') }}</strong>
            </span>
          @endif
        </div>

        <div class="form-group has-feedback {{ $errors->has('link') ? 'has-error' : '' }}">
          {{ Form::label('link', 'Đường dẫn') }}
          {{ Form::text('link', old('link'), ['class' => 'form-control', 'required', 'autocomplete' => 'off']) }}
          @if ($errors->has('link'))
          <span class="help-block">
            <strong>{{ $errors->first('link') }}</strong>
            </span>
          @endif
        </div>
        
        <div class="form-group has-feedback {{ $errors->has('publish') ? 'has-error' : '' }}">
          {{ Form::label('publish', 'Công khai hoạt động') }}
          {{ Form::select('publish', ['1' => 'Có','0' => 'Không'], old('publish'), ['class' => 'form-control', 'required', 'placeholder' => 'Chọn 1 trong số những lựa chọn sau']) }}
          @if ($errors->has('publish'))
          <span class="help-block">
            <strong>{{ $errors->first('publish') }}</strong>
            </span>
          @endif
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
      </div>
    </div>
  {!! Form::close() !!}
@endsection

@section('css')
<style type="text/css">
  textarea {
    resize: none;
  }
</style>
@endsection

@section('js')
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#previewImg').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#image").change(function() {
    readURL(this);
  });
</script>
@endsection
