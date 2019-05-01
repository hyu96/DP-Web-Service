@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Export người dùng</h1>
@stop

@section('content')
    @if(!empty($errors->all()))
        <div class="text-danger">
            Lỗi:
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    {!! Form::open(['url' => route('admin.users.exportUser'), 'method' => 'post']) !!}
        <div class="row">
            <div class="col-md-4 form-group has-feedback {{ $errors->has('district_id') ? 'has-error' : '' }}">
                {{ Form::label('district_id', 'Quận/Huyện') }}
                <select class="form-control search-select" name="district_id" id="district-select" required>
                    <option></option>
                    @foreach ($districts as $district)
                        <option value={{ $district->id }}>{{ $district->name }}</option>
                    @endforeach
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
                    <option></option>
                    @foreach ($subdistricts as $subdistrict)
                        <option value={{ $subdistrict->id }}>{{ $subdistrict->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('subdistrict_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('subdistrict_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            {{ Form::submit("Export người dùng", ['class' => 'btn btn-primary']) }}
        </div>
    {!! Form::close() !!}
@endsection

@section('js')
<script>
    $( function() {
        $('.search-select').select2({
            placeholder: 'Chọn 1 trong số lựa chọn sau',
            allowClear: true
        });

        if ({{$isSuperadministrator}}) {
            $('#subdistrict-select').prop('disabled', true);
            $('#district-select').on('change', function (e) {
                var districtValue = $('#district-select').val();
                if (districtValue === '') { 
                    $('#subdistrict-select').prop('disabled', true);
                    $('#subdistrict-select').empty().select2({
                        placeholder: 'Chọn 1 trong số lựa chọn sau',
                        data: [],
                        allowClear: true
                    });

                } else {
                    $.ajax({
                        url : "/api/subdistricts",
                        type : "post",
                        data : {
                            district_id : districtValue
                        },
                        success : function (result){
                            $('#subdistrict-select').prop('disabled', false);
                            $('#subdistrict-select').empty().select2({
                                data: result.subdistricts,
                                allowClear: true
                            });
                        }
                    });
                }
            });
        }
    });
</script>
@stop