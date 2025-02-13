@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Customer: {{ $customer->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                </div>

                @if (auth()->guard('admin')->check())
                    <div class="mb-3">
                        <label class="form-label">Assign to Employee</label>
                        <select name="employee_id" class="form-select">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" 
                                    {{ $customer->employees->contains($employee->id) ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Update Customer</button>
            </form>
        </div>
    </div>
</div>
@endsection