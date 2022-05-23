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
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="nama" value="{{ old('nama') }}" autofocus required>
                    @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                      <div class="invalid-feedback"></div>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name">No. Whatsapp</label>
                      <input type="number" class="form-control @error('no_wa') is-invalid @enderror" value="{{ old('no_wa') }}" name="no_wa" required>
                      @error('no_wa')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="last_name">Alamat</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                      <!-- <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div> -->
                      @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Konfirmasi Password</label>
                      <input id="password2" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
                      @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
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