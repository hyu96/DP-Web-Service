@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Danh sách quản trị viên</h1>
@stop

@section('content')
    <table id="user-table" class="table table-striped table-bordered display nowrap" style="width:100%">
    <thead>
        <tr>
        <th>Id</th>
        <th>Họ Tên</th>
        <th>Ảnh cá nhân</th>
        <th>Địa chỉ email</th>
        <th>Số điện thoại</th>
        <th>Giới tính</th>
        <th>Ngày sinh</th>
        <th>Cấp</th>
        <th>Quận/Huyện</th>
        <th>Chỉnh sửa</th>
        <th>Xóa</th>
        </tr>
    </thead>
    </table>

    <form action="/admins/" method="post" id="delete-form">
        @csrf
        <input type="hidden" name="_method" value="delete" />
        <div id="myModal" class="modal" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Xoá cán bộ quản lý</h4>
              </div>
              <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa thông tin cán bộ quản lý này không ?</p>
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
#admins-avatar {
    width: 125px;
    height: 125px;
}
</style>
@endsection

@section('js')
    <script>
        $( function() {
            $('#user-table').DataTable( {
                'ajax': '/api/admins',
                'scrollX': true,
                'fixedHeader': true,
                'columns': [
                    { data: 'id' },
                    { data: 'name' },
                    {
                        data: 'image',
                        render: function ( data, type, row, meta ) {
                            var html = '';
                            if (data === null) {
                                html += "<img id='admins-avatar' src='/image/anonymous.png'/>"
                            } else {
                                html += `<img id='admins-avatar' src='/avatars/admins/${data}'/>`
                            }
                            return html;
                        },
                    },
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
                    { data: 'birthday' },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            if (row.role === 0) {
                                return 'Thành phố';
                            } else {
                                return 'Quận';
                            }
                        },
                    },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            if (row.district) {
                                return row.district.name;
                            } else {
                                return '';
                            }
                        },
                    },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            var html = '';
                            html += `<a class='btn btn-info user-info' href='/admins/${row.id}' style='margin-right: 20px; width: 80px'>Thông tin</a>`;
                            return html;
                        },
                    },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            var html = '';
                            if ('{{Auth::user()->role === 0}}') {
                                html += `<a class='btn btn-danger btn-delete-admin' style='width: 80px' data-id='${row.id}'>Xóa</button>`;
                            }
                            return html;
                        },
                    },
                ],
                'columnDefs': [ {
                    'targets': [8],
                    'orderable': false,
                }]
            });

            $(document).on('click', '.btn-delete-admin', function(e) {
                deleteId = $(this).data('id');
                $('#myModal').modal();
            })

            $(document).on('click', '.btn-submit-modal', function(e) {
                e.preventDefault();
                var url = 'api/admins/' + deleteId;
                console.log(url);
                $.ajax({
                    url : url,
                    type : "delete",
                    data : $(this).serialize(),
                    success : function (result){
                        window.location.href = "{{ route('admin.admins.index')}}";
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
