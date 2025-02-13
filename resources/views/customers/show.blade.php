@extends('layouts.app')

@section('title', 'Customer Details - ' . $customer->name)

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Customer Details: {{ $customer->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Contact Information</h5>
                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                    <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Assigned Employees</h5>
                    <ul>
                        @foreach($customer->employees as $employee)
                            <li>{{ $employee->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Actions History</h5>
            @if($customer->actions->isEmpty())
                <div class="alert alert-info">No actions recorded yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Result</th>
                                <th>Employee</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($customer->actions as $action)
                          <tr>
                              <td>{{ ucfirst($action->type) }}</td>
                              <td>
                                  {{ $action->result }}
                                  <button class="btn btn-sm btn-link edit-action-btn"
                                          data-action-id="{{ $action->id }}"
                                          data-action-result="{{ $action->result }}">
                                      <i class="fas fa-edit"></i>
                                  </button>
                              </td>
                              <td>{{ $action->employee->name }}</td>
                              <td>{{ $action->created_at->format('M d, Y H:i') }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Single Dynamic Modal -->
<div class="modal fade" id="editActionModal" tabindex="-1" aria-labelledby="editActionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editActionModalLabel">Edit Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editActionForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="result" class="form-label">Result</label>
                        <textarea class="form-control" id="result" name="result" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const editActionModal = document.getElementById('editActionModal');
    const editActionForm = document.getElementById('editActionForm');
    const resultTextarea = document.getElementById('result');

    // Event listener for edit buttons
    document.querySelectorAll('.edit-action-btn').forEach(button => {
        button.addEventListener('click', function () {
            const actionId = this.dataset.actionId;
            const actionResult = this.dataset.actionResult;

            // Update form action URL using Laravel's route() helper
            editActionForm.action = `{{ route('actions.update', ':actionId') }}`.replace(':actionId', actionId);

            // Populate the textarea with the current result
            resultTextarea.value = actionResult;

            // Show the modal
            new bootstrap.Modal(editActionModal).show();
        });
    });
});
</script>
@endpush