@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Thông tin cán bộ quản lý</h1>
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
        {!! Form::open(['url' => route('api.admins.edit', ['id' => $id]), 'method' => 'put', 'id' => 'admin-register-form', 'files' => true]) !!}
            @csrf
            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
                    {{ Form::label('image', 'Ảnh cá nhân') }}
                    {{ Form::file('image', ['accept' => 'image/x-png,image/gif,image/jpeg', 'id' => 'image']) }}
                    <div id="img-preview"></div>
                    @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    {{ Form::label('name', 'Họ tên') }}
                    {{ Form::text('name', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => !$editable]) }}
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-input has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::email('email', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => !$editable]) }}
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('role') ? 'has-error' : '' }}">
                    {{ Form::label('role', 'Chức vụ') }}
                    {{ Form::select('role', ['Cán bộ quản lý thành phố', 'Cán bộ quản lý cấp quận'], '', ['class' => 'form-control role', 'disabled' => !$editable]) }}
                    @if ($errors->has('role'))
                    <span class="help-block">
                        <strong>{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('district_id') ? 'has-error' : '' }}">
                    {{ Form::label('district_id', 'Quận/Huyện') }}
                    <select class="form-control search-select" name="district_id" id="district-select" disabled>
                        <option></option>
                    </select>
                    @if ($errors->has('district_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('district_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('gender') ? 'has-error' : '' }}">
                    {{ Form::label('gender', 'Giới tính') }}
                    {{ Form::select('gender', ['male' => 'Nam','female' => 'Nữ'], '', ['class' => 'form-control', 'required', 'placeholder' => 'Chọn 1 trong số những lựa chọn sau', 'disabled' => !$editable]) }}
                    @if ($errors->has('gender'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('birthday') ? 'has-error' : '' }}">
                    {{ Form::label('birthday', 'Ngày sinh') }}
                    {{ Form::text('birthday', '', ['class' => 'form-control', 'id' => 'birthday', 'required', 'autocomplete' => 'off', 'disabled' => !$editable]) }}
                    @if ($errors->has('birthday'))
                        <span class="help-block">
                            <strong>{{ $errors->first('birthday') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
                    {{ Form::label('phone', 'Số điện thoại') }}
                    {{ Form::text('phone', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => !$editable]) }}
                    @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('identity_card') ? 'has-error' : '' }}">
                    {{ Form::label('identity_card', 'Số chứng minh thư nhân dân') }}
                    {{ Form::text('identity_card', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => !$editable]) }}
                    @if ($errors->has('identity_card'))
                    <span class="help-block">
                        <strong>{{ $errors->first('identity_card') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            @if ($editable)
            <div class="form-input">
                <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
            </div>
            @endif
        {!! Form::close() !!}
    </div>
@stop

@section('css')
<style type="text/css">
#errors-msg {
    display: none;
}

#success-msg {
    display: none;
}

#admin-register-form {
    margin-right: 35px;
    height: 100%;
}

#admin-register-form .form-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

#admin-register-form .form-input {
    width: 48%;
}
</style>
@stop

@section('js')
<script>
    $( function () {
        $.ajax({
            url : '/api/districts',
            type : "get",
            success : function (result){
                districts = result.data.map((district, index) => {
                    return {
                        id: district.id,
                        text: district.name
                    }
                })
                $('#district-select').select2({
                    data: districts,
                    placeholder: 'Chọn 1 trong số lựa chọn sau',
                    allowClear: true
                });
                getUserData();
            }
        });

        $('.role').on('change', function(e) {
            var value = $(this).val()
            console.log(value)
            console.log(typeof value)
            if (value === '0') {
                $('#district-select').prop('disabled', true);
            } else {
                $('#district-select').prop('disabled', false);
            }
        })

        $('form').submit(function(e) {
            $("#success-msg").css("display", "none");
            $("#errors-msg").css("display", "none");
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                type : "put",
                data : $(this).serialize(),
                success : function (result){
                    $("#success-msg").css("display", "block");
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

        $("#image").change(function() {
          readURL(this);
        });
    });

    function getUserData() {
        var data = {};
        $.ajax({
            url : '/api/admins/{{$id}}',
            type : "get",
            success : function (result){
                fillData(result.data);
            },
            error: function (response) {
            }
        });
        return data;
    }

    function fillData(data) {
        $('#name').val(data.name);
        $('#email').val(data.email);
        $('#phone').val(data.phone);
        $('#birthday').val(data.birthday);
        $('#gender').val(data.gender);
        $('#identity_card').val(data.identity_card);
        $('#role').val(data.role);
        if (data.district_id) {
            $('#district-select').val(data.district_id).trigger('change.select2');
        }
        if ('{{ $editable }}' && data.role === 1) {
            $('#district-select').prop('disabled', false);
        }
    };

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#img-preview ').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
</script>
@stop