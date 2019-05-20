@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Import người dùng</h1>
@stop

@section('content')
    <div class="alert alert-danger" id="errors-msg">
       <div id="errors-line-index"></div>
       <div id="errors-container"></div>
    </div>

    <div class="alert alert-success" id="success-msg">
        Import dữ liệu thành công
    </div>

    {!! Form::open(['url' => route('api.users.import'), 'method' => 'post', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-4 form-group has-feedback {{ $errors->has('district_id') ? 'has-error' : '' }}">
                {{ Form::label('district_id', 'Quận/Huyện') }}
                <select class="form-control search-select" name="district_id" id="district-select" readonly>
                    <option value="{{$district->id}}">{{ $district->name }}</option>
                </select>
                @if ($errors->has('district_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('district_id') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-4 form-group has-feedback {{ $errors->has('subdistrict_id') ? 'has-error' : '' }}">
                {{ Form::label('subdistrict_id', 'Phường/Xã/Thị Trấn') }}
                <select class="form-control search-select" name="subdistrict_id" id="subdistrict-select" required>
                </select>
                @if ($errors->has('subdistrict_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('subdistrict_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::file('user_file', ['accept'=> '.xlsx', 'required' => 'true']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Import người dùng', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
    <div>*Tải mẫu file tại <a href="{{ route('admin.users.template') }}">đây</a></div>
@endsection

@section('css')
<style type="text/css">
#errors-msg {
    display: none;
}

#success-msg {
    display: none;
}
</style>
@endsection

@section('js')
<script>
    $( function() {
        $.ajax({
            url : "/api/subdistricts?district={{$district->id}}",
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

        $('form').submit(function(e) {
            e.preventDefault();
            var data = new FormData($(this)[0]);
            $("#success-msg").css("display", "none");
            $("#errors-msg").css("display", "none");
            $.ajax({
                type: 'POST',
                data: data,
                url: $(this).attr('action'),
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function(data) {
                    $("#success-msg").css("display", "block");
                },
                error: function(res) {
                    $("#errors-container").html('');
                    var errors = JSON.parse(res.responseText).messages;
                    $('#errors-line-index').html(`Dữ liệu không phù hợp ở dòng <b>${errors.index[0]}</b>:`)
                    Object.keys(errors).forEach(function(key) {
                        if (key === 'index') {
                            return;
                        }
                        $("#errors-container").append($("<li>").text(errors[key][0]));
                    });
                    $("#errors-msg").css("display", "block");
                }
            });
        })
    });
</script>
@stop