@extends('adminlte::page')

@section('title', 'Dạng tật')

@section('content_header')
    <h1>Dạng tật</h1>
@stop

@section('content')
    <div class="alert alert-danger" id="errors-msg">
       Dữ liệu nhập vào không phù hợp:
       <div id="errors-container"></div>
    </div>
    
    <div class="alert alert-success" id="success-msg">
       Thêm dạng tật thành công
    </div>

    <div class="alert alert-success" id="delete-msg">
       Xóa dạng tật thành công
    </div>


    {!! Form::open(['url' => route('api.disability.store'), 'method' => 'post', 'id' => 'create-form']) !!}
        <div class="row">
            <div class="col-md-4 form-group has-feedback {{ $errors->has('district_id') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Tên') }}
                {{ Form::text('name', old('name'), ['class' => 'form-control', 'required', 'autocomplete' => 'off']) }}
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            {{ Form::submit("Thêm dạng tật", ['class' => 'btn btn-primary']) }}
        </div>
    {!! Form::close() !!}
    <h4>Danh sách</h4>
    <table id="disability-table" class="table table-striped table-bordered display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Tên</th>
            <th>Chỉnh sửa</th>
            <th>Xóa</th>
        </tr>
    </thead>
    </table>

    <form action="/disabilities/" method="post" id="delete-form">
        @csrf
        <input type="hidden" name="_method" value="delete" />
        <div id="myModal" class="modal" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Xoá dạng tật</h4>
              </div>
              <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa dạng tật này không ?</p>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-submit-modal">Xóa</button>
                <button type="button" class="btn " data-dismiss="modal">Đóng</button>
              </div>
            </div>
          </div>
        </div>
    </form>
@endsection

@section('css')
<style>
h4 {
    font-weight: bold;
    margin-top: 45px;
    font-size: 20px;
}

#errors-msg {
    display: none;
}

#success-msg {
    display: none;
}

#delete-msg {
    display: none;
}


</style>
@endsection

@section('js')
<script type="text/javascript">
    $( function() {
        var table = $('#disability-table').DataTable( {
            'ajax': '/api/disabilities',
            'scrollX': true,
            'fixedHeader': true,
            'columns': [
                { data: 'id' },
                { data: 'name' },
                {
                    data: '',
                    render: function ( data, type, row, meta ) {
                        var html = '';
                        html += `<a class='btn btn-info disability-info' href='/disabilities/${row.id}'><i class='fa fa-edit'></i> Thông tin</a>`;
                        return html;
                    },
                },
                {
                    data: '',
                    render: function ( data, type, row, meta ) {
                        var html = '';
                        html += `<a class='btn btn-danger btn-delete-disability' data-id='${row.id}'><i class='fa fa-trash-o'></i> Xóa</a>`;
                        return html;
                    },
                }
            ]
        });

        $(document).on('click', '.btn-delete-disability', function(e) {
            deleteId = $(this).data('id');
            $('#myModal').modal();
        })

        $(document).on('click', '.btn-submit-modal', function(e) {
            e.preventDefault();
            var url = 'api/disabilities/' + deleteId;
            $.ajax({
                url : url,
                type : "delete",
                data : $(this).serialize(),
                success : function (result){
                    $('#myModal').modal('hide');
                    $("#delete-msg").css("display", "block");
                    $("#delete-msg").fadeOut(8000);
                    table.ajax.reload();
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

        $('#create-form').submit(function(e) {
            $("#success-msg").css("display", "none");
            $("#errors-msg").css("display", "none");
            $("#delete-msg").css("display", "none");
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                type : "post",
                data : $(this).serialize(),
                success : function (result){
                    $("#success-msg").css("display", "block");
                    $("#success-msg").fadeOut(8000);
                    table.ajax.reload();
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
</script>
@endsection

