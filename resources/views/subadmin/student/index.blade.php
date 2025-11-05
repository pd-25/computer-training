@extends('subadmin.layout.main')
@section('title', 'All Students')

<style>
    .fixed-btn {
        position: fixed;
        bottom: 50px;
        right: 30px;
        width: 50px;
        height: 50px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .fixed-btn:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

    /* Alert */
    #alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .alert {
        min-width: 280px;
        max-width: 360px;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        color: #fff;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: slideIn 0.4s ease, fadeOut 0.5s ease 4s forwards;
    }

    .alert-success {
        background-color: #16a34a !important;
        color: white !important;
        border: none;
    }

    .alert-danger {
        background-color: #dc2626 !important;
        color: white !important;
        border: none;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }

        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
</style>
@section('content')
<section class="section dashboard">

    <div class="row">


        <div class="col-xxl-12 col-md-12">
            <div class="card info-card sales-card">

                <div class="card-body">
                    <div class="d-flex justify-between align-items-center">
                        <h5 class="card-title w-100">All Students</h5>

                    </div>

                    <table class="table table-responsive table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Student Details</th>
                                <th>Father's Name</th>
                                <th>Admission Date</th>
                                <th>Organization</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    @if($student->image)
                                    <img src="{{ asset($student->image) }}" alt="Profile" width="50" height="50" class="rounded-circle">
                                    @else
                                    <img src="{{ asset('assets/images/default-avatar.png') }}" alt="Default" width="50" height="50" class="rounded-circle">
                                    @endif
                                </td>

                                <td>
                                    <p class="m-0 badge bg-primary">Enrollment no: {{ $student->enrollment_no }}</p>
                                    <p class="m-0">Student Name: {{ $student->name }}</p>
                                    <p class="m-0">Email: {{ $student->email }}</p>
                                    <p class="m-0">Mobile: {{ $student->phone }}</p>
                                    <p class="m-0">DOB: {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d-m-Y') : '-' }}</p>
                                </td>
                                <td>{{ $student->father_name ?? '-' }}</td>
                                <td>{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $student->org_name }}</td>

                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStudent{{ $student->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStudent{{ $student->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">No students found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>


    <!-- Add Button -->
    <button class="fixed-btn" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        Add
    </button>

    <!-- Add Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" action="{{ route('subadmin.students.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3"> <!-- g-3 adds spacing between columns -->

                        <div class="col-md-4">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Father's Name</label>
                            <input type="text" name="father_name" class="form-control" placeholder="Enter father's name">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Admission Date</label>
                            <input type="date" name="admission_date" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Organization Name</label>
                            <input type="text" name="org_name" class="form-control"
                                value="{{ Auth::guard('subadmin')->user()->org_name ?? '' }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                    </div>
                </div>

                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Edit Modal -->
    @foreach($students as $student)
    <div class="modal fade" id="editStudent{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" action="{{ route('subadmin.students.edit', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ $student->phone }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Father's Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ $student->father_name }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ $student->dob }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Admission Date</label>
                            <input type="date" name="admission_date" class="form-control" value="{{ $student->admission_date }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Organization Name</label>
                            <input type="text" class="form-control" value="{{ $student->org_name }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if($student->image)
                            <img src="{{ asset($student->image) }}" class="mt-2 rounded" width="80">
                            @endif
                        </div>

                    </div>
                </div>

                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach


    <!-- {{-- Delete Modal --}} -->
    @foreach($students as $student)
    <div class="modal fade" id="deleteStudent{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('subadmin.students.delete', $student->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $student->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach


    <!-- Alerts -->
    <div id="alert-container">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.querySelectorAll("#alert-container .alert").forEach(el => {
                    el.remove();
                });
            }, 2500);
        });
    </script>


</section>
@endsection