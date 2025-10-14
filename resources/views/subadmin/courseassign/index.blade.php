@extends('subadmin.layout.main')
@section('title', 'All Assigned Courses')

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
                        <h5 class="card-title w-100">All Assigned Courses</h5>

                    </div>

                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Assigned Courses</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $key => $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-transform: capitalize;">{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    @if(!empty($student->assigned_course_id))
                                    <ul class="mb-0">
                                        @foreach($student->assigned_course_id as $courseId)
                                        @php
                                        $course = $courses->firstWhere('id', $courseId);
                                        @endphp
                                        @if($course)
                                        <li>{{ $course->course_name }}</li>
                                        @endif
                                        @endforeach
                                    </ul>
                                    @else
                                    <span class="text-muted">No Courses Assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">

                                        <button class="btn btn-sm btn-primary btn-edit-student" data-bs-toggle="modal" data-bs-target="#editStudent{{ $student->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger btn-delete-student" data-bs-toggle="modal" data-bs-target="#deleteStudent{{ $student->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>



                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#generateIdCard{{ $student->id }}">Generate ID</button>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#generateCertificate{{ $student->id }}">Generate Certificate</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="d-flex justify-content-end">
                                        @if ($students->hasPages())
                                        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                                            <!-- {{-- Prev Button --}} -->
                                            <a href="{{ $students->previousPageUrl() ?? '#' }}"
                                                class="btn btn-outline-primary btn-sm {{ $students->onFirstPage() ? 'disabled' : '' }}">
                                                Prev
                                            </a>

                                            <!-- {{-- Current Page Input --}} -->
                                            <input type="text"
                                                class="form-control form-control-sm text-center"
                                                value="{{ $students->currentPage() }}"
                                                readonly
                                                style="width: 60px;">

                                            <span>/</span>

                                            <!-- {{-- Last Page Input --}} -->
                                            <input type="text"
                                                class="form-control form-control-sm text-center"
                                                value="{{ $students->lastPage() }}"
                                                readonly
                                                style="width: 60px;">

                                            <!-- {{-- Next Button --}} -->
                                            <a href="{{ $students->nextPageUrl() ?? '#' }}"
                                                class="btn btn-outline-primary btn-sm {{ !$students->hasMorePages() ? 'disabled' : '' }}">
                                                Next
                                            </a>
                                        </div>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        </tfoot>
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
            <form class="modal-content" action="{{ route('subadmin.course-assign.add') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Assign Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Choose Student<span class="text-danger">*</span></label>
                        <select name="student_id" class="form-select" required>
                            <option value="" selected disabled>Select Student</option>
                            @foreach($sts as $st)
                            <option value="{{ $st->id }}">{{ $st->name }} ({{ $st->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Assign Course <span class="text-danger">*</span></label>
                        <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                            @foreach($courses as $course)
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="assigned_course_id[]"
                                    value="{{ $course->id }}"
                                    id="assigned_course_{{ $course->id }}">
                                <label class="form-check-label" for="assigned_course_{{ $course->id }}">
                                    {{ $course->course_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
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
            <form class="modal-content" method="POST" action="{{ route('subadmin.course-assign.edit', $student->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Assigned Courses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Student Name -->
                    <div class="mb-3">
                        <label>Student Name</label>
                        <input type="text" class="form-control" value="{{ $student->name }}" readonly>
                    </div>

                    <!-- Student Email -->
                    <div class="mb-3">
                        <label>Student Email</label>
                        <input type="email" class="form-control" value="{{ $student->email }}" readonly>
                    </div>

                    <!-- Assigned Courses -->
                    <div class="mb-3">
                        <label>Assigned Courses</label>
                        <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                            @foreach($courses as $course)
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="assigned_course_id[]"
                                    value="{{ $course->id }}"
                                    id="edit_course_{{ $course->id }}"
                                    @if(in_array($course->id, $student->assigned_course_id ?? [])) checked @endif>
                                <label class="form-check-label" for="edit_course_{{ $course->id }}">
                                    {{ $course->course_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach


    <!-- Generate Certificate Modal -->
    @foreach($students as $student)
    <div class="modal fade" id="generateCertificate{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" action="{{ route('subadmin.certificate.generate') }}" method="POST" target="_blank">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Generate Certificate for {{ $student->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Student Name -->
                    <div class="mb-3">
                        <label>Student Name</label>
                        <input type="text" class="form-control" value="{{ $student->name }}" readonly>
                    </div>

                    <!-- Student Email -->
                    <div class="mb-3">
                        <label>Student Email</label>
                        <input type="email" class="form-control" value="{{ $student->email }}" readonly>
                    </div>

                    <!-- Assigned Courses -->
                    <div class="mb-3">
                        <label>Select Course to Generate Certificate</label>
                        <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                            @foreach($student->assigned_course_id as $course_id)
                            @php
                            $course = $courses->where('id', $course_id)->first();
                            @endphp
                            @if($course)
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="radio"
                                    name="course_id"
                                    value="{{ $course->id }}"
                                    id="course_{{ $student->id }}_{{ $course->id }}">
                                <label class="form-check-label" for="course_{{ $student->id }}_{{ $course->id }}">
                                    {{ $course->course_name }}
                                </label>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Generate Certificate</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Generate ID Card Modal -->
    @foreach($students as $student)
    <div class="modal fade" id="generateIdCard{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" action="{{ route('subadmin.idcard.generate') }}" method="POST" target="_blank">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Generate ID Card for {{ $student->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Student Name -->
                    <div class="mb-3">
                        <label>Student Name</label>
                        <input type="text" class="form-control" value="{{ $student->name }}" readonly>
                    </div>

                    <!-- Student Email -->
                    <div class="mb-3">
                        <label>Student Email</label>
                        <input type="email" class="form-control" value="{{ $student->email }}" readonly>
                    </div>

                    <!-- Assigned Courses -->
                    <div class="mb-3">
                        <label>Select Course to Generate Certificate</label>
                        <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                            @foreach($student->assigned_course_id as $course_id)
                            @php
                            $course = $courses->where('id', $course_id)->first();
                            @endphp
                            @if($course)
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="radio"
                                    name="course_id"
                                    value="{{ $course->id }}"
                                    id="course_{{ $student->id }}_{{ $course->id }}">
                                <label class="form-check-label" for="course_{{ $student->id }}_{{ $course->id }}">
                                    {{ $course->course_name }}
                                </label>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Generate ID Card</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach







    <!-- Delete Modal -->
    @foreach($students as $key => $student)
    <div class="modal fade" id="deleteStudent{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{route('subadmin.course-assign.delete', $student->id)}}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteStudentName">{{ $student->name }}</strong>?</p>
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