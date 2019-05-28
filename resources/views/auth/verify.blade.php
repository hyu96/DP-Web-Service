@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Xác thực địa chỉ email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Đường dẫn xác thực mới đã được gửi tới email của bạn')}}
                        </div>
                    @endif

                    {{ __('Trước khi tiến hành, vui lòng kiểm tra email để nhận đường dẫn xác thực.')}}
                    {{ __('Nếu bạn không nhận được email') }}, <a href="{{ route('verification.resend') }}">{{ __('click vào đây để nhận yêu cầu mới') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
