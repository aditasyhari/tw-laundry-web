@extends('backend.layouts.index')

@section('title') Profile @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <h4>PROFILE</h4>
        <hr>
    @if(Auth::user()->email_verified_at == null)
        <h5 class="alert-heading">Email anda belum terverifikasi.</h5>
        <div class="alert-body">
            <form action="{{ url('/email/verify') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-small btn-primary">Kirim email verifikasi</button>
            </form>
        </div>
    @endif
    </div>
</div>
<br>
<div class="row">
    <div class="col col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ url('/profile/ubah-password') }}">
                    @csrf
                    @method('put')
                    @if(Auth::user()->password != null)
                        <div class="form-group col-md-12">
                            <label for="password" class="d-block">Password Lama</label>
                            <input id="password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required>
                            @error('old_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label for="password" class="d-block">Password Baru</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="password2" class="d-block">Konfirmasi Password</label>
                        <input id="password2" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col col-md-6">
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ url('/profile/ubah') }}">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="frist_name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="nama" value="{{ Auth::user()->nama }}" autofocus required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                <div class="form-group col-6">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required>
                    <div class="invalid-feedback"></div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="last_name">No. Whatsapp</label>
                    <input type="number" class="form-control @error('no_wa') is-invalid @enderror" value="{{ Auth::user()->no_wa }}" name="no_wa" required>
                    @error('no_wa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </div>
                <div class="form-group">
                    <label for="last_name">Alamat</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ Auth::user()->alamat }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Ubah Profile
                    </button>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>

@endsection