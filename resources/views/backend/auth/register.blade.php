@extends('backend.auth.index')

@section('title') Register @endsection

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
        <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ url('/register') }}">
                  @csrf
                  <div class="form-group">
                    <label for="frist_name">Nama</label>
                    <input type="text" class="form-control" name="name" autofocus required>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" name="email" required>
                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name">No. Telp</label>
                      <input type="number" class="form-control" name="no_telp" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="last_name">Alamat</label>
                    <textarea name="address" class="form-control" required></textarea>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Konfirmasi Password</label>
                      <input id="password2" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="agree" required>
                      <label class="custom-control-label" for="agree">Saya setuju dengan ketentuan yang berlaku.</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
              <div class="mb-4 text-muted text-center">
                Sudah punya akun? <a href="{{ url('login') }}">Login</a>
              </div>
            </div>
    </div>
</div>
@endsection

@section('js')@endsection