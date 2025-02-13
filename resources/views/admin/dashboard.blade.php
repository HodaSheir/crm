@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5>Employees</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($employees as $employee)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $employee->name }}
                        <span class="badge bg-primary">{{ $employee->email }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5>Customers</h5>
            </div>
            <div class="card-body">
                @foreach($customers as $customer)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>{{ $customer->name }}</strong>
                        <div class="text-muted">{{ $customer->email }}</div>
                        <!-- Show assigned employees -->
                        @if($customer->employees->count() > 0)
                            <small class="text-info">
                                Assigned to: {{ $customer->employees->pluck('name')->implode(', ') }}
                            </small>
                        @endif
                    </div>
                    <form action="{{ route('admin.assign.customer', $customer->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <select class="form-select" name="employee_id">
                                @foreach($employees as $employee)
                                <option @if($customer->employees->contains($employee->id)) selected @endif
                                     value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-success" type="submit">Assign</button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection