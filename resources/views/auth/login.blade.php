@extends('app')

@section('content')
    <div class="d-flex justify-content-center px-3 align-items-center vh-100 h-100">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="card-title fw-bold fs-4 text-center">
                    Welcome to University App
                </div>
                <form action="{{ route('authenticate') }}" method="post">
                    @csrf
                    <div class="d-flex flex-column gap-3">
                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div>
                            <label for="login-username-email">Username or Email</label>
                            <input type="text" name="user_email" required
                                class="form-control @error('user_email') is-invalid @enderror" id="#login-username-email"
                                placeholder="Input text here..." />
                            @error('user_email')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <div>
                            <label for="login-password">Password</label>
                            <input type="password" name="password" required
                                class="form-control @error('password') is-invalid @enderror" id="#login-password"
                                placeholder="Input text here...">
                            @error('password')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
