@extends('layouts.app', ['title' => 'Tambah User'])
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-user-circle"></i> TAMBAH USER</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        @if($errors->first('message'))
                        <div class="col-12">
                            <div class="border-left-primary">
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('message') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NAMA LENGKAP</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        placeholder="Masukkan Nama User"
                                        class="form-control @error('name') is-invalid @enderror">
                                    <small class="form-text text-danger">{{ $errors->first('name') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ALAMAT EMAIL</label>
                                    <input type="email" name="email" value="{{ old('name', $user->email )}}"
                                        placeholder=" Masukkan Alamat Email"
                                        class="form-control @error('email') is-invalid @enderror">
                                    <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password" placeholder=" Masukkan Password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    <small class="form-text text-danger">{{ $errors->first('password') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>KONFIRMASI PASSWORD</label>
                                    <input type="password" name="password_confirmation"
                                        placeholder="Masukkan Konfirmasi Password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            UPDATE</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection