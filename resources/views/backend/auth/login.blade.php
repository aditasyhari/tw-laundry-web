@extends('backend.auth.index')

@section('title') Login @endsection

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
                <form method="POST" action="#" class="needs-validation" novalidate="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                        <div class="invalid-feedback">
                            Silahkan isi email anda
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
                            <div class="float-right">
                            <a href="{{ route('password.request') }}" class="text-small">
                                Lupa Password?
                            </a>
                            </div>
                        </div>
                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                        <div class="invalid-feedback">
                            Silahkan isi password anda
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                            <label class="custom-control-label" for="remember-me">Ingat Saya</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                </form>
                <div class="text-center mt-4 mb-3">
                    <div class="text-job text-muted">Login With</div>
                </div>
                <div class="row sm-gutters">
                    <div class="col-6">
                        <a class="btn btn-block btn-social btn-danger" href="{{ url('auth/google') }}">
                            <span class="fab fa-google-plus"></span> Google
                        </a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-block btn-social btn-success">
                            <span class="fab fa-whatsapp"></span> Whatsapp
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 text-muted text-center">
            Tidak punya akun? <a href="{{ url('/register') }}">Buat akun</a>
        </div>
    </div>
</div>
@endsection

@section('js')@endsection