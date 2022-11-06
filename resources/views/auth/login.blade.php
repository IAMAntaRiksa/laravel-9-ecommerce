@extends('layouts.auth', ['title' => 'Login'])
@section('content')
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="img-logo text-center mt-5">
                <img src="{{ asset('assets/img/company.png') }}" style="width: 80px;">
            </div>
            <div class="card o-hidden border-0 shadow-lg mb-3 mt-5">
                <div class="card-body p-4">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="text-center">
                        <h1 class="h5 text-gray-900 mb-3">LOGIN ADMIN</h1>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold text-uppercase">Email address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan Alamat Email">
                            @error('email')
                            <div class="alert alert-dangermt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-uppercase">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan Password">
                            @error('password')
                            <div class="alert alert-dangermt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                        <hr>
                        <a href="/forgot-password">Lupa Password?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection