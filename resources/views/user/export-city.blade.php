@extends('adminlte::page')

@section('title', 'Export thông tin người khuyết tật')

@section('content_header')
    <h1>Export thông tin người khuyết tật</h1>
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
                </select>
                @if ($errors->has('subdistrict_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('subdistrict_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            {{ Form::submit("Export", ['class' => 'btn btn-primary']) }}
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

        $('#subdistrict-select').prop('disabled', true);
        $("#district-select").select2({
            ajax: {
                url: "/api/districts",
                type: "GET",
                data: function (params) {
                    return {
                        q: params.term, // search term
                    };
                },
                processResults: function (result) {
                    return {
                        results: $.map(result.data, function (subdistrict) {
                            return {
                                id: subdistrict.id,
                                text: subdistrict.name
                            }
                        })
                    };
                }
            },
            placeholder: 'Chọn 1 trong số lựa chọn sau',
            allowClear: true,
        });

        $('#district-select').on('change', function (e) {
            var district = $('#district-select').val();
            if (district === '') { 
                $('#subdistrict-select').prop('disabled', true);
                $('#subdistrict-select').empty().select2({
                    placeholder: 'Chọn 1 trong số lựa chọn sau',
                    data: [],
                    allowClear: true
                });
            } else {
                $.ajax({
                    url : `/api/subdistricts?district=${district}`,
                    type : "get",
                    success : function (result){
                        $('#subdistrict-select').prop('disabled', false);
                        $('#subdistrict-select').empty().select2({
                            data: result.data.map(function(subdistrict, index) {
                                console.log(subdistrict)
                                return {
                                    id: subdistrict.id,
                                    text: subdistrict.name
                                }
                            }),
                            allowClear: true
                        });
                    }
                });
            }
        });
    });
</script>
@stop