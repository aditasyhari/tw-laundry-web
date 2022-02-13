@extends('backend.auth.index')

@section('title') Login - Masukkan Kode OTP @endsection

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Login</h4>
            </div>
            <div class="card-body">
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <form method="POST" action="{{ url('auth/wa-login') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label for="">Masukkan OTP</label>
                        <input type="hidden" name="no_telp" value="{{ $no_telp }}">
                        <input id="" type="number" class="form-control" name="otp" tabindex="1" required autofocus>
                        <div class="invalid-feedback">
                            Silahkan masukkan kode OTP anda
                        </div>
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-5 text-muted text-center">
            Tidak punya akun? <a href="{{ url('/register') }}">Buat akun</a>
        </div>
    </div>
</div>
@endsection

@section('js')@endsection