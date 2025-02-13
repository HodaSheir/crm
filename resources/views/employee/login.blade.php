@extends('layouts.app')

@section('title', 'Employee Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Employee Login</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('employee.login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                 {{-- Add Admin Login Link --}}
                <div class="mt-3 text-center">
                    <small>
                        Are you an <b>Admin </b>?
                        <a href="{{ route('admin.login') }}">Login here</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection