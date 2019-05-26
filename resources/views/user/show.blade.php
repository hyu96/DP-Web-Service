@extends('adminlte::page')

@section('title', 'Thông tin người dùng')

@section('content_header')
    <h1>Thông tin chi tiết người dùng</h1>
@stop

@section('content')
    <div class="alert alert-danger" id="errors-msg">
       Dữ liệu nhập vào không phù hợp:
       <div id="errors-container"></div>
    </div>
    
    <div class="alert alert-success" id="success-msg">
       Cập nhật thông tin người khuyết tật thành công
    </div>

    @php
        $disabled = Auth::user()->role === 0 ? true : false
    @endphp
	<div>
        {!! Form::open(['url' => route('api.users.edit', ['id' => $id]), 'method' => 'put', 'id' => 'edit-user-form']) !!}
            @csrf
            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    {{ Form::label('name', 'Họ tên') }}
                    {{ Form::text('name', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => $disabled]) }}
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-input has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::email('email', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => $disabled]) }}
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('gender') ? 'has-error' : '' }}">
                    {{ Form::label('gender', 'Giới tính') }}
                    {{ Form::select('gender', ['male' => 'Nam','female' => 'Nữ'], '', ['class' => 'form-control', 'required', 'placeholder' => 'Chọn 1 trong số những lựa chọn sau', 'disabled' => $disabled]) }}
                    @if ($errors->has('gender'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('birthday') ? 'has-error' : '' }}">
                    {{ Form::label('birthday', 'Ngày sinh') }}
                    {{ Form::text('birthday', '', ['class' => 'form-control', 'id' => 'birthday', 'required', 'autocomplete' => 'off', 'disabled' => $disabled]) }}
                    @if ($errors->has('birthday'))
                        <span class="help-block">
                            <strong>{{ $errors->first('birthday') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('district_id') ? 'has-error' : '' }}">
                    {{ Form::label('district_id', 'Quận/Huyện') }}
                    <select class="form-control search-select" name="district_id" id="district-select" readonly>
                    </select>
                    @if ($errors->has('district_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('district_id') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('subdistrict_id') ? 'has-error' : '' }}">
                    {{ Form::label('subdistrict_id', 'Phường/Xã/Thị Trấn') }}
                    {{ Form::select('subdistrict_id', [], '', ['class' => 'form-control search-select', 'id' => "subdistrict-select",'disabled' => $disabled]) }}
                    @if ($errors->has('subdistrict_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('subdistrict_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('address') ? 'has-error' : '' }}">
                    {{ Form::label('address', 'Địa Chỉ Thường Trú') }}
                    {{ Form::textarea('address', '', ['class' => 'form-control', 'id' => 'address', 'rows' => '3', 'required', 'disabled' => $disabled]) }}
                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
                    {{ Form::label('phone', 'Số điện thoại') }}
                    {{ Form::text('phone', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => $disabled]) }}
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('identity_card') ? 'has-error' : '' }}">
                    {{ Form::label('identity_card', 'Số chứng minh thư') }}
                    {{ Form::text('identity_card', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'disabled' => $disabled]) }}
                    @if ($errors->has('identity_card'))
                    <span class="help-block">
                        <strong>{{ $errors->first('identity_card') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('labor_ability') ? 'has-error' : '' }}">
                    {{ Form::label('labor_ability', 'Khả năng lao động') }}
                    {{ Form::select('labor_ability', ['1' => 'Có','0' => 'Không'], '', ['class' => 'form-control', 'required', 'placeholder' => 'Chọn 1 trong số những lựa chọn sau', 'disabled' => $disabled]) }}
                    @if ($errors->has('labor_ability'))
                        <span class="help-block">
                            <strong>{{ $errors->first('labor_ability') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('academic_level') ? 'has-error' : '' }}">
                    {{ Form::label('academic_level', 'Trình Độ Học Vấn') }}
                    {{ Form::text('academic_level', '', ['class' => 'form-control', 'required', 'disabled' => $disabled]) }}
                    @if ($errors->has('academic_level'))
                        <span class="help-block">
                            <strong>{{ $errors->first('academic_level') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-input has-feedback {{ $errors->has('specialize') ? 'has-error' : '' }}">
                    {{ Form::label('specialize', 'Chuyên Môn') }}
                    {{ Form::text('specialize', '', ['class' => 'form-control', 'disabled' => $disabled]) }}
                    @if ($errors->has('specialize'))
                    <span class="help-block">
                        <strong>{{ $errors->first('specialize') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('employment_status') ? 'has-error' : '' }}">
                    {{ Form::label('employment_status', 'Công Việc Đang Làm (Nếu Có)') }}
                    {{ Form::text('employment_status', '', ['class' => 'form-control', 'disabled' => $disabled]) }}
                    @if ($errors->has('employment_status'))
                    <span class="help-block">
                        <strong>{{ $errors->first('employment_status') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('income') ? 'has-error' : '' }}">
                    {{ Form::label('income', 'Thu Nhập Cá Nhân') }}
                    {{ Form::text('income', '', ['class' => 'form-control', 'required', 'disabled' => $disabled]) }}
                    @if ($errors->has('income'))
                        <span class="help-block">
                            <strong>{{ $errors->first('income') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-input has-feedback {{ $errors->has('disability') ? 'has-error' : '' }}">
                    {{ Form::label('disability', 'Hình thức khuyết tật') }}
                    {{ Form::select('disability', $disabilities, '', ['class' => 'form-control', 'required', 'placeholder' => 'Chọn 1 trong số những lựa chọn sau', 'disabled' => $disabled]) }}
                    @if ($errors->has('disability'))
                    <span class="help-block">
                        <strong>{{ $errors->first('disability') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-input has-feedback {{ $errors->has('disability_detail') ? 'has-error' : '' }}">
                    {{ Form::label('disability_detail', 'Chi tiết tình trạng khuyết tật') }}
                    {{ Form::text('disability_detail', '', ['class' => 'form-control', 'required', 'disabled' => $disabled]) }}
                    @if ($errors->has('disability_detail'))
                        <span class="help-block">
                            <strong>{{ $errors->first('disability_detail') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group has-feedback {{ $errors->has('need') ? 'has-error' : '' }}">
                {{ Form::label('need', 'Nhu Cầu') }}
                <div class="checkbox-container">
                    @foreach ($needs as $need)
                        <div class="checkbox need-item" data-id={{$need->id}}>
                            @if ($need->detail === 'Học nghề')
                                <label>
                                    {{ Form::checkbox('need[]', $need->id, false, ['disabled' => $disabled])}}
                                    Học nghề (Ghi rõ nghề muốn học)
                                </label>
                                <br/>
                                {{ Form::text('user-job-detail', '', ['disabled' => $disabled, 'id' => 'user-job-detail']) }}
                            @else
                                <label>
                                    {{ Form::checkbox('need[]', $need->id, false, ['disabled' => $disabled]) }}
                                    {{ $need->detail }}
                                </label>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if ($errors->has('need'))
                    <span class="help-block">
                        <strong>{{ $errors->first('need') }}</strong>
                    </span>
                @endif
            </div>
            
            @if(!$disabled)
            <div class="form-input">
                <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
            </div>
            @endif
        {!! Form::close() !!}
    </div>
@endsection

@section('css')
<style type="text/css">
#errors-msg {
    display: none;
}

#success-msg {
    display: none;
}

#edit-user-form {
    margin-right: 35px;
    height: 100%;
}

#edit-user-form .form-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

#edit-user-form .form-input {
    width: 48%;
}

textarea {
    resize: none;
}

.checkbox-container {
    display: flex;
    flex-wrap: wrap;
}

.checkbox {
    flex-basis: 30%;
    margin-top: 0px;
}

.has-error .checkbox label{
    color: #333;
}

select[readonly].select2-hidden-accessible + .select2-container {
    pointer-events: none;
    touch-action: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
    background: #eee;
    box-shadow: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow, select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
    display: none;
}

</style>
@stop

@section('js')
<script>
    $( function() {
        getUserData();
        setBirthdayInput();

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
    });

    function getUserData() {
        var data = {};
        $.ajax({
            url : '/api/users/{{$id}}',
            type : "get",
            success : function (result){
                fillData(result.data);
                getSubdistrictData(result.data);
            },
            error: function (response) {
                window.location.href = "{{ route('page.404')}}";
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
        $('#labor_ability').val(data.labor_ability);
        $('#identity_card').val(data.identity_card);
        $('#district-select').select2({
            data: [{
                id: data.district.id,
                text: data.district.name
            }]
        });
        $('#subdistrict-select').val(data.subdistrict.id).trigger('change.select2');
        $('#address').val(data.address);
        $('#academic_level').val(data.academic_level);
        $('#specialize').val(data.specialize);
        $('#employment_status').val(data.employment_status);
        $('#income').val(data.income);
        $('#disability').val(data.disability_id);
        $('#disability_detail').val(data.disability_detail);
        $.each(data.needs, function( index, need ) {
            $(`.need-item[data-id=${need.need_id}] input[type=checkbox]`).prop('checked', true);
            if (need.need_id === 3) {
                $(`.need-item[data-id=${need.need_id}] input[type=text]`).val(need.detail);
            }
        });
    }

    function setBirthdayInput() {
        $('#birthday').datetimepicker({
            timepicker:false,
            format: 'Y-m-d'
        });
    }

    function getSubdistrictData(user) {
        $.ajax({
            url : `/api/subdistricts?district=${user.district.id}`,
            type : "get",
            success : function (result){
                subdistricts = result.data.map((subdistrict, index) => {
                    return {
                        id: subdistrict.id,
                        text: subdistrict.name
                    }
                })
                $('#subdistrict-select').select2({
                    data: subdistricts,
                    placeholder: 'Chọn 1 trong số lựa chọn sau',
                    allowClear: true
                });
            }
        });
    }
</script>
@stop