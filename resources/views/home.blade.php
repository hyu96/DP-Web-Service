@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Hệ thống quản lý người khuyết tật DP Hà Nội</h1>
@stop

@section('content')
    Trang quản lí người dùng và hoạt động<br>
    @if (Auth::user()->role === 0) 
        Đang đăng nhập với vai trò <b>cán bộ quản lý thành phố</b>
    @else
        Đang đăng nhập với vai trò <b>cán bộ quản lý cấp quận</b>
    @endif
@stop
