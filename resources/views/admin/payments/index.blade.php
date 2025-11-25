@extends('admin.layout.main')
@section('title', 'Payment Requests')
@section('content')



@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">All Payment Requests</h5>
                    <div>
                        <span class="badge bg-warning">Pending: {{ $totalPayments->where('status', 'pending')->count() }}</span>
                        <span class="badge bg-success">Approved: {{ $totalPayments->where('status', 'approved')->count() }}</span>
                        <span class="badge bg-danger">Rejected: {{ $totalPayments->where('status', 'rejected')->count() }}</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Org. Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Requested Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($totalPayments as $franchise)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $franchise->subadmin->subadmin_unique_id }}</strong> <br>
                                    {{ $franchise->subadmin->org_name }}
                                </td>
                                <td>{{ $franchise->subadmin->name }}</td>
                                <td>{{ $franchise->subadmin->email }}</td>
                                <td>₹{{ number_format($franchise->amount, 0) }}</td>
                                <td>
                                    @if($franchise->status == 'pending')
                                    <span class="badge bg-warning">
                                        {{ ucfirst($franchise->status) }}
                                    </span>
                                    @elseif($franchise->status == 'approved')
                                    <span class="badge bg-success">
                                        {{ ucfirst($franchise->status) }}
                                    </span>
                                    @elseif($franchise->status == 'rejected')
                                    <span class="badge bg-danger">
                                        {{ ucfirst($franchise->status) }}
                                    </span>
                                    @endif
                                </td>
                                <td>{{ $franchise->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewFranchise{{ $franchise->id }}" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    @if($franchise->status == 'pending')
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#acceptFranchise{{ $franchise->id }}" title="Accept">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#rejectFranchise{{ $franchise->id }}" title="Reject">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    @endif

                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteFranchise{{ $franchise->id }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No franchise requests found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- VIEW DETAILS MODAL -->
@foreach($totalPayments as $franchise)
<div class="modal fade" id="viewFranchise{{ $franchise->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Franchise Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <strong>Payment Receipt:</strong><br>
                        <img src="{{asset('storage/'.$franchise->payment_reciept)}}" width="200" alt="">
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Enrollment ID:</strong>
                        <p>{{ $franchise->subadmin->subadmin_unique_id }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <p>{{ $franchise->subadmin->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong>
                        <p>{{ $franchise->subadmin->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Payment Amount:</strong>
                        <p>₹{{ number_format($franchise->amount, 2) }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong>
                        <p><span class="text-dark">{{ ucfirst($franchise->status) }}</span></p>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Organization/ Institution Name:</strong>
                        <p>{{ $franchise->subadmin->org_name ?? 'N/A' }}</p>
                    </div>
                    @if($franchise->reject_reason)
                    <div class="col-12 mb-3">
                        <strong>Rejection Reason:</strong>
                        <p class="text-danger">{{ $franchise->reject_reason }}</p>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <strong>Submitted On:</strong>
                        <p>{{ $franchise->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- ACCEPT MODAL -->
@foreach($totalPayments as $franchise)
<div class="modal fade" id="acceptFranchise{{ $franchise->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.payments.accept', $franchise->id) }}" method="POST">
            @csrf
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Accept Payment Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to accept the payment request <strong>{{ $franchise->subadmin->name }}</strong>?</p>
                <div class="alert alert-info">
                    <strong>Details:</strong>
                    Requested Amount: ₹{{ number_format($franchise->amount, 2) }}
                </div>
                <p class="text-muted small">An approval notification will be sent to {{ $franchise->subadmin->email }}</p>

                <label for="addamounttowallet{{ $franchise->id }}">Add Amount to Wallet</label>
                <input type="hidden" name="subadmin_id" value="{{ $franchise->subadmin->id }}">
                <input type="text" class="form-control" id="addamounttowallet{{ $franchise->id }}" name="amount" value="{{ $franchise->amount }}" min="0" step="0.01" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Approve Request</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- REJECT MODAL -->
@foreach($totalPayments as $franchise)
<div class="modal fade" id="rejectFranchise{{ $franchise->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.payments.reject', $franchise->id) }}" method="POST">
            @csrf
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Reject Payment Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject the payment request from <strong>{{ $franchise->subadmin->name }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-warning">Reject Request</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- DELETE MODAL -->
@foreach($totalPayments as $franchise)
<div class="modal fade" id="deleteFranchise{{ $franchise->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.payments.delete', $franchise->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Payment Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to permanently delete the payment request from <strong>{{ $franchise->subadmin->name }}</strong>?</p>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i> This action cannot be undone!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete Permanently</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection