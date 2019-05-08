@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Thông tin cán bộ quản lý</h1>
@stop

@section('content')
    <div>
        {!! Form::open(['url' => route('api.admins.edit', ['id' => $id]), 'method' => 'put', 'id' => 'admin-register-form']) !!}
            @csrf
            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    {{ Form::label('name', 'Họ tên') }}
                    {{ Form::text('name', $admin->name, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => true]) }}
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-input has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::email('email', $admin->email, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => true]) }}
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
                    {{ Form::select('role', ['Cán bộ quản lý thành phố', 'Cán bộ quản lý cấp quận'], $admin->role, ['class' => 'form-control role', 'disabled' => true]) }}
                    @if ($errors->has('role'))
                    <span class="help-block">
                        <strong>{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('district_id') ? 'has-error' : '' }}">
                    {{ Form::label('district_id', 'Quận/Huyện') }}
                    <select class="form-control search-select" name="district_id" id="district-select" disabled>
                        @if(!empty($admin->district))
                            <option value={{$admin->district_id}}>{{ $admin->district->name }}</option>
                        @endif
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
                    {{ Form::select('gender', ['male' => 'Nam','female' => 'Nữ'], $admin->gender, ['class' => 'form-control', 'required', 'placeholder' => 'Chọn 1 trong số những lựa chọn sau', 'disabled' => true]) }}
                    @if ($errors->has('gender'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('birthday') ? 'has-error' : '' }}">
                    {{ Form::label('birthday', 'Ngày sinh') }}
                    {{ Form::text('birthday', $admin->birthday, ['class' => 'form-control', 'id' => 'birthday', 'required', 'autocomplete' => 'off', 'disabled' => true]) }}
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
                    {{ Form::text('phone', $admin->phone, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => true]) }}
                    @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('identity_card') ? 'has-error' : '' }}">
                    {{ Form::label('identity_card', 'Số chứng minh thư nhân dân') }}
                    {{ Form::text('identity_card', $admin->identity_card, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => true]) }}
                    @if ($errors->has('identity_card'))
                    <span class="help-block">
                        <strong>{{ $errors->first('identity_card') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@stop

@section('css')
<style type="text/css">
#errors-msg {
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
    $( function() {
    });

    function setBirthdayInput () {
        $('#birthday').datetimepicker({
            timepicker:false,
            format: 'Y-m-d'
        });
    }

    function fillData() {
        $('#name').val('Do Quang Huy');
        $('#password').val('123456789');
        $('#password_confirmation').val('123456789');
        $('#email').val('huydq2510@gmail.com');
        $('#phone').val('0368636007');
        $('#birthday').val('1996-10-25');
        $('#gender').val('male');
        $('#labor_ability').val('1');
        $('#identity_card').val('123456789');
        $('#subdistrict-select').val('2');
        $('#address').val('Số 14, ngõ 463 đường Hồng Hà, Hoàn Kiếm, Hà Nội');
        $('#academic_level').val('10/10');
        $('#specialize').val('CNTT');
        $('#employment_status').val('Làm văn phòng');
        $('#income').val('9500000');
        $('#disability').val('5');
        $('#disability_detail').val('Bình thường');
    };
</script>
@stop