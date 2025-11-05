@extends('admin.layout.main')
@section('title', 'Franchise Requests')
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
                    <h5 class="card-title">All Franchise Requests</h5>
                    <div>
                        <span class="badge bg-warning">Pending: {{ $franchises->where('status', 'pending')->count() }}</span>
                        <span class="badge bg-success">Approved: {{ $franchises->where('status', 'approved')->count() }}</span>
                        <span class="badge bg-danger">Rejected: {{ $franchises->where('status', 'rejected')->count() }}</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Investment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($franchises as $franchise)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $franchise->name }}</td>
                                <td>{{ $franchise->email }}</td>
                                <td>{{ $franchise->phone }}</td>
                                <td>{{ $franchise->city }}{{ $franchise->state ? ', ' . $franchise->state : '' }}</td>
                                <td>₹{{ number_format($franchise->investment, 0) }}</td>
                                <td>
                                    <span class="badge bg-{{ $franchise->status_badge }}">
                                        {{ ucfirst($franchise->status) }}
                                    </span>
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
@foreach($franchises as $franchise)
<div class="modal fade" id="viewFranchise{{ $franchise->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Franchise Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <p>{{ $franchise->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong>
                        <p>{{ $franchise->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Phone:</strong>
                        <p>{{ $franchise->phone }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Location:</strong>
                        <p>{{ $franchise->city }}{{ $franchise->state ? ', ' . $franchise->state : '' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Investment Amount:</strong>
                        <p>₹{{ number_format($franchise->investment, 2) }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong>
                        <p><span class="badge bg-{{ $franchise->status_badge }}">{{ ucfirst($franchise->status) }}</span></p>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Organization/ Institution Name:</strong>
                        <p>{{ $franchise->experience ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Message:</strong>
                        <p>{{ $franchise->message ?? 'N/A' }}</p>
                    </div>
                    @if($franchise->reject_reason)
                    <div class="col-12 mb-3">
                        <strong>Rejection Reason:</strong>
                        <p class="text-danger">{{ $franchise->reject_reason }}</p>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <strong>Submitted On:</strong>
                        <p>{{ $franchise->created_at->format('M d, Y h:i A') }}</p>
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
@foreach($franchises as $franchise)
<div class="modal fade" id="acceptFranchise{{ $franchise->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.franchise.accept', $franchise->id) }}" method="POST">
            @csrf
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Accept Franchise Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to accept the franchise request from <strong>{{ $franchise->name }}</strong>?</p>
                <div class="alert alert-info">
                    <strong>Details:</strong><br>
                    Location: {{ $franchise->city }}{{ $franchise->state ? ', ' . $franchise->state : '' }}<br>
                    Investment: ₹{{ number_format($franchise->investment, 2) }}
                </div>
                <p class="text-muted small">An approval notification will be sent to {{ $franchise->email }}</p>
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
@foreach($franchises as $franchise)
<div class="modal fade" id="rejectFranchise{{ $franchise->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.franchise.reject', $franchise->id) }}" method="POST">
            @csrf
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Reject Franchise Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject the franchise request from <strong>{{ $franchise->name }}</strong>?</p>

                <div class="mb-3">
                    <label for="reject_reason{{ $franchise->id }}" class="form-label">Reason for Rejection (Optional)</label>
                    <textarea name="reject_reason" id="reject_reason{{ $franchise->id }}" class="form-control" rows="3" placeholder="Provide a reason for rejection..."></textarea>
                    <small class="text-muted">This reason will be included in the notification email.</small>
                </div>
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
@foreach($franchises as $franchise)
<div class="modal fade" id="deleteFranchise{{ $franchise->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.franchise.delete', $franchise->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Franchise Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to permanently delete the franchise request from <strong>{{ $franchise->name }}</strong>?</p>
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