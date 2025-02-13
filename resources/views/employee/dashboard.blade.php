@extends('layouts.app')

@section('title', 'Employee Dashboard')

@section('content')
    <div class="container">
        {{-- Add Customer Button --}}
        <div class="mb-4">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New Customer
            </a>
        </div>
        <!-- Unassigned Customers Section -->
        <div class="card shadow mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Unassigned Customers</h5>
            </div>
            <div class="card-body">
                @if ($unassignedCustomers->isEmpty())
                    <div class="alert alert-info">All customers are assigned!</div>
                @else
                    @foreach ($unassignedCustomers as $customer)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">{{ $customer->name }}</h5>
                                        <p class="card-text text-muted">{{ $customer->email }}</p>
                                        <p class="card-text"><small class="text-muted">Phone: {{ $customer->phone }}</small>
                                        </p>
                                    </div>
                                    <form action="{{ route('employee.add.action', $customer->id) }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <select class="form-select" name="type">
                                                <option value="call">Call</option>
                                                <option value="visit">Visit</option>
                                                <option value="follow_up">Follow Up</option>
                                            </select>
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-plus"></i> Add Action
                                            </button>
                                        </div>
                                        <div class="input-group">
                                            <textarea class="form-control" name="result" placeholder="Result" rows="5" cols="5"></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- My Customers Section -->
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">My Assigned Customers</h5>
            </div>
            <div class="card-body">
                @if ($myCustomers->isEmpty())
                    <div class="alert alert-info">You don't have any assigned customers yet</div>
                @else
                     @foreach ($myCustomers as $customer)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">{{ $customer->name }}</h5>
                                        <p class="card-text text-muted">{{ $customer->email }}</p>
                                        <p class="card-text"><small class="text-muted">Phone: {{ $customer->phone }}</small></p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        {{-- Action Form --}}
                                        <form action="{{ route('employee.add.action', $customer->id) }}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <select class="form-select" name="type">
                                                    <option value="call">Call</option>
                                                    <option value="visit">Visit</option>
                                                    <option value="follow_up">Follow Up</option>
                                                </select>
                                                <textarea class="form-control" name="result" placeholder="Result" rows="1"></textarea>
                                                <button class="btn btn-success" type="submit">
                                                    <i class="fas fa-plus"></i> Add Action
                                                </button>
                                            </div>
                                        </form>

                                        {{-- Edit Button --}}
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Show Button --}}
                                        <a href="{{ route('customers.show', $customer) }}" class="text-decoration-none">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        {{-- Delete Button --}}
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete customer?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
