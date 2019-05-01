@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Danh sách hoạt động</h1>
@stop

@section('content')
    <table id="news-table" class="table table-striped table-bordered display nowrap" style="width:100%">
    <thead>
        <tr>
          <th>Id</th>
          <th>Nội dung hoạt động</th>
          <th>Đường dẫn</th>
          <th>Công khai</th>
          <th>Chỉnh sửa</th>
        </tr>
    </thead>
    </table>
@endsection


@section('css')
<style type="text/css">
#news-table a {
  display: block;
  width: 150px;
}
</style>
@stop

@section('js')
  <script>
    $( function() {
      $('#news-table').DataTable({
          'data': {!! $newsList !!},
          "scrollX": true,
          'fixedHeader': true,
          'columns': [
            { data: 'id' },
            { data: 'title' },
            { data: 'link' },
            {
              data: 'publish',
              render: function ( data, type, row, meta ) {
                if (data === 1) {
                  return "<a class='btn btn-danger'><i class='fa fa-times' aria-hidden='true'></i> Không công khai</a>"
                } else {
                  return "<a class='btn btn-success'><i class='fa fa-check' aria-hidden='true'></i> Công khai</a>"
                }
              },
            },
            {
              data: '',
              render: function ( data, type, row, meta ) {
                return "<a class='btn btn-primary' href='/admin/news/" + row.id + "'><i class='fa fa-edit' aria-hidden='true'></i> Chỉnh sửa</a>"
              },
            }
          ]
      });
    });
  </script>
@endsection

