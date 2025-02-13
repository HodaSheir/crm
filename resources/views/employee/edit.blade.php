@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Employee: {{ $employee->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Update Employee</button>
            </form>
        </div>
    </div>
</div>
@endsection