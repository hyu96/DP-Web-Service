@extends('adminlte::page')

@section('title', 'Thay đổi mật khẩu')

@section('content_header')
    <h1>Thay đổi mật khẩu</h1>
@stop

@section('content')
    <div class="alert alert-danger" id="errors-msg">
       Dữ liệu nhập vào không phù hợp:
       <div id="errors-container"></div>
    </div>
    
    <div class="alert alert-success" id="success-msg">
       Cập nhật thông tin người khuyết tật thành công
    </div>

    <div>
        {!! Form::open(['url' => route('api.admins.reset.password'), 'method' => 'put', 'id' => 'reset-password-form']) !!}
            @csrf
            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    {{ Form::label('password', 'Mật khẩu cũ') }}
                    {{ Form::password('password', ['class' => 'form-control', 'required', 'autocomplete' => 'off']) }}
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('new_password') ? 'has-error' : '' }}">
                    {{ Form::label('new_password', 'Mật khẩu mới') }}
                    {{ Form::password('new_password', ['class' => 'form-control', 'required', 'autocomplete' => 'off']) }}
                    @if ($errors->has('new_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
                    {{ Form::label('new_password_confirmation', 'Nhập lại mật khẩu mới') }}
                    {{ Form::password('new_password_confirmation', ['class' => 'form-control', 'id' => 'new_password_confirmation', 'required', 'autocomplete' => 'off']) }}
                    @if ($errors->has('new_password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-input">
                <button type="submit" class="btn btn-primary">Thay đổi</button>
            </div>
        {!! Form::close() !!}
    </div>
@stop

@section('css')
<style type="text/css">
#errors-msg {
    display: none;
}

#reset-password-form {
    margin-right: 35px;
    height: 100%;
}

#reset-password-form .form-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

#reset-password-form .form-input {
    width: 48%;
}

#errors-msg {
    display: none;
}

#success-msg {
    display: none;
}
</style>
@stop

@section('js')
<script>
    $( function() {
        $('form').submit(function(e) {
            e.preventDefault();
            $("#success-msg").css("display", "none");
            $("#errors-msg").css("display", "none");
            $.ajax({
                url : $(this).attr('action'),
                type : "put",
                data : $(this).serialize(),
                success : function (result){
                    document.getElementById('logout-form').submit();
                },
                error: function (response) {
                    $("#errors-container").html('');
                    var errors = JSON.parse(response.responseText).messages;
                    Object.keys(errors).forEach(function(key) {
                        $("#errors-container").append($("<li>").text(errors[key][0]));
                    });
                    $("#errors-msg").css("display", "block");
                }
            });
        })
    });    
</script>
@stop