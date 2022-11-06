@extends('layouts.auth', ['title' => 'Forgot Password'])
@section('content')
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="img-logo text-center mt-5">
            </div>
            <br>
            <br>
            <div class="card o-hidden border-0 shadow-lg mb-3 mt-5">
                <div class="card-body p-4">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="text-center">
                        <h1 class="h5 text-gray-900 mb-3">TWO FACTOR CHALLANGE</h1>
                    </div>
                    <form method="POST" action="{{ url('/two-factor-challenge') }}">
                        @csrf
                        <div class="form-group">
                            <label class="text-uppercase">Code</label>
                            <input type="text" id="code" class="form-control" name="code" />
                        </div>
                        <p class="text-muted">
                            <i>Atau Anda dapat memasukkan salah satu recovery code.</i>
                        </p>
                        <div class="form-group">
                            <label class="text-uppercase">Recovery Code</label>
                            <input type="text" id="recovery_code" class="form-control" name="recovery_code" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                LOGIN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection