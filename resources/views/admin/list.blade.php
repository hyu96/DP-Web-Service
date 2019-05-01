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
                            html += `<a class='btn btn-info user-info' href='/admins/admins/${row.id}' style='margin-right: 20px; width: 80px'>Thông tin</a>`;
                            return html;
                        },
                    },
                    {
                        data: '',
                        render: function ( data, type, row, meta ) {
                            var html = '';
                            html += "<a class='btn btn-danger' style='width: 80px'>Xóa</button>";
                            return html;
                        },
                    },
                ],
                'columnDefs': [ {
                    'targets': [8],
                    'orderable': false,
                }]
            });
        });
    </script>
@endsection
