@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Danh sách người khuyết tật</h1>
@stop

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success">
            {!! \Session::get('success') !!}
        </div>
    @endif
    <table id="user-table" class="table table-striped table-bordered display nowrap" style="width:100%">
    <thead>
        <tr>
        <th>Id</th>
        <th>Họ Tên</th>
        <th>Địa chỉ email</th>
        <th>Số điện thoại</th>
        <th>Giới tính</th>
        <th>Địa chỉ</th>
        <th>Quận/Huyện</th>
        <th>Phường/Xã</th>
        <th>Chỉnh sửa</th>
        <th>Xóa</th>
        </tr>
    </thead>
    </table>

    <form action="/users/" method="post" id="delete-form">
        @csrf
        <input type="hidden" name="_method" value="delete" />
        <div id="myModal" class="modal" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Xoá người khuyết tật</h4>
              </div>
              <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa thông tin người khuyết tật này không ?</p>
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
<style type="text/css">
#user-table button {
    width: 100px;
}
</style>
@stop

@section('js')
    <script>
        $( function() {
            var approveId = null;
            $('#user-table').DataTable( {
                'ajax': '/api/users',
                'scrollX': true,
                'fixedHeader': true,
                'columns': [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'phone' },
                    {
                        data: 'gender',
                        render: function ( data, type, row, meta ) {
                            if (data === "male") {
                                return 'Nam';
                            } else {
                                return 'Nữ';
                            }
                        },
                    },
                    { data: 'address' },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            return row.district.name;
                        },
                    },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            return row.subdistrict.name;
                        },
                    },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            var html = '';
                            html += `<a class='btn btn-info user-info' href='/users/${row.id}'><i class='fa fa-edit'></i> Thông tin</a>`;
                            return html;
                        },
                    },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            var html = '';
                            if ('{{Auth::user()->role === 1}}') {
                                html += `<a class='btn btn-danger btn-delete-user' data-id='${row.id}'><i class='fa fa-trash-o'></i> Xóa</a>`;
                            }
                            return html;
                        },
                    }
                ],
            });

            $(document).on('click', '.btn-delete-user', function(e) {
                deleteId = $(this).data('id');
                $('#myModal').modal();
            })

            $(document).on('click', '.btn-submit-modal', function(e) {
                e.preventDefault();
                var url = 'api/users/' + deleteId;
                console.log(url);
                $.ajax({
                    url : url,
                    type : "delete",
                    data : $(this).serialize(),
                    success : function (result){
                        window.location.href = "{{ route('admin.users.index')}}";
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
@endsection
