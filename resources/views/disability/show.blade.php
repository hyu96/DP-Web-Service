@extends('adminlte::page')

@section('title', 'Thông tin dạng tật')

@section('content_header')
    <h1>Thông tin dạng tật</h1>
@stop

@section('content')
    <div class="alert alert-danger" id="errors-msg">
       Dữ liệu nhập vào không phù hợp:
       <div id="errors-container"></div>
    </div>
    
    <div class="alert alert-success" id="success-msg">
       Chỉnh sửa dạng tật thành công
    </div>

    {!! Form::open(['url' => route('api.disability.edit', ['id' => $id]), 'method' => 'put', 'id' => 'create-form']) !!}
        <div class="row">
            <div class="col-md-4 form-group has-feedback {{ $errors->has('district_id') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Tên') }}
                {{ Form::text('name', '', ['class' => 'form-control', 'required', 'autocomplete' => 'off']) }}
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            {{ Form::submit("Chỉnh sửa", ['class' => 'btn btn-primary']) }}
        </div>
    {!! Form::close() !!}
@endsection

@section('css')
<style>
#errors-msg {
    display: none;
}

#success-msg {
    display: none;
}
</style>
@endsection

@section('js')
<script type="text/javascript">
    $( function() {
        getDisabilityData();

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
                    $("#success-msg").fadeOut(8000);
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
    })

    function fillData(data) {
        $('#name').val(data.name);
    }

    function getDisabilityData() {
        var data = {};
        $.ajax({
            url : '/api/disabilities/{{$id}}',
            type : "get",
            success : function (result){
                fillData(result.data);
            },
            error: function (response) {
            }
        });
        return data;
    }
</script>
@endsection

                {{-- // window.location.href = "{{ route('page.404')}}"; --}}
