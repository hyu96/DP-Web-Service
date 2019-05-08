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
                <select class="form-control search-select" name="district_id" id="district-select" disabled>
                    <option value={{ $district->id }}>{{ $district->name }}</option>
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
            {{ Form::submit("Export người dùng", ['class' => 'btn btn-primary']) }}
        </div>
    {!! Form::close() !!}
@endsection

@section('js')
<script>
    $( function() {
        $("#subdistrict-select").select2({
            ajax: {
                url: "/api/subdistricts?district={{ $district->id }}",
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

        // $('form').submit(function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         type: 'get',
        //         data: {
        //             subdistrict_id: $('#district-select').val()
        //         },
        //         url: $(this).attr('action'),
        //         success: function(data) {
        //             $("#success-msg").css("display", "block");
        //         },
        //         error: function(res) {
        //             $("#errors-container").html('');
        //             var errors = JSON.parse(res.responseText).messages;
        //             $('#errors-line-index').html(`Dữ liệu không phù hợp ở dòng <b>${errors.index[0]}</b>:`)
        //             Object.keys(errors).forEach(function(key) {
        //                 if (key === 'index') {
        //                     return;
        //                 }
        //                 $("#errors-container").append($("<li>").text(errors[key][0]));
        //             });
        //             $("#errors-msg").css("display", "block");
        //         }
        //     });
        // })
    });
</script>
@stop