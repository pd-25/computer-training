@extends('subadmin.layout.main')
@section('title', 'All Assigned Courses')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

                        <form action="{{ route('subadmin.course-assign') }}" method="GET" class="w-50 d-flex gap-2">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search enrollment or email or name...">

                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>

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
                            @forelse($students as $index => $student)
                            <tr>
                                <td>{{ $students->firstItem() + $index }}</td>
                                <td style="text-transform: capitalize;">{{ $student->name }}</td>
                                <td>
                                    <p class="m-0 fw-bold">Enrollment: {{ $student->enrollment_no }}</p>
                                    <p class="m-0">Email: {{ $student->email }}</p>
                                </td>
                                <td>
                                    @if(!empty($student->assigned_course_id))
                                    <ul class="mb-0">
                                        @foreach($student->assigned_course_id as $courseId)
                                        @php
                                        $course = $courses->firstWhere('id', $courseId);
                                        @endphp
                                        @if($course)
                                        <li>Enrollment: <strong>{{ $course->course_unique_id }}</strong></li>
                                        <li>Name: <strong>{{ $course->course_name }}</strong></li>
                                        <li>Duration: <strong>{{ $course->duration }} Months</strong></li>
                                        @endif
                                        @endforeach
                                    </ul>
                                    @else
                                    <span class="text-muted">No Courses Assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">

                                        <!-- <button class="btn btn-sm btn-primary btn-edit-student" data-bs-toggle="modal" data-bs-target="#editStudent{{ $student->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->

                                        <!-- <button class="btn btn-sm btn-danger btn-delete-student" data-bs-toggle="modal" data-bs-target="#deleteStudent{{ $student->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button> -->

                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#generateIdCard{{ $student->id }}">Generate ID</button>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#generateIdMarks{{ $student->id }}">Give Marks</button>
                                        <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#downloadMarksheetIndividual{{ $student->id }}">
                                            <i class="bi bi-eye"></i> View Marksheets
                                        </button>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#generateCertificate{{ $student->id }}"><i class="bi bi-eye"></i> Generate Certificate</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No students with assigned courses found.</td>
                            </tr>
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="d-flex justify-content-end">
                                        @if ($students->hasPages())
                                        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                                            <!-- Prev Button -->
                                            <a href="{{ $students->appends(['search' => request('search')])->previousPageUrl() ?? '#' }}"
                                                class="btn btn-outline-primary btn-sm {{ $students->onFirstPage() ? 'disabled' : '' }}">
                                                Prev
                                            </a>

                                            <!-- Current Page Input -->
                                            <input type="text"
                                                class="form-control form-control-sm text-center"
                                                value="{{ $students->currentPage() }}"
                                                readonly
                                                style="width: 60px;">

                                            <span>/</span>

                                            <!-- Last Page Input -->
                                            <input type="text"
                                                class="form-control form-control-sm text-center"
                                                value="{{ $students->lastPage() }}"
                                                readonly
                                                style="width: 60px;">

                                            <!-- Next Button -->
                                            <a href="{{ $students->appends(['search' => request('search')])->nextPageUrl() ?? '#' }}"
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
                        <label>Search Student by Email / Enrollment No <span class="text-danger">*</span></label>
                        <input type="text" id="studentSearch" class="form-control" placeholder="Enter Email or Enrollment No">
                        <small class="text-muted">Type minimum 3 characters...</small>
                    </div>

                    <!-- Auto Display Result -->
                    <div id="studentResult" class="p-2 border rounded mb-3" style="display:none;">
                        <strong>Name:</strong> <span id="resName"></span><br>
                        <strong>Email:</strong> <span id="resEmail"></span><br>
                        <strong>Enrollment:</strong> <span id="resEnroll"></span>
                        <input type="hidden" name="student_id" id="selectedStudentId">
                    </div>

                    <div class="mb-3">
                        <label>Choose Course Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="categorySelect" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Use Select2 Dropdown -->
                    <div class="mb-3">
                        <label>Assign Course <span class="text-danger">*</span></label>
                        <select name="assigned_course_id[]" id="courseSelect" class="form-control" multiple="multiple">
                            <option value="">Select courses...</option>
                        </select>
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
                                    {{ $course->course_name }} - {{ $course->category->name }}
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
                        <label>Date of Issue</label>
                        <input type="date" class="form-control" name="issue_date_certificate">
                    </div>

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
                    <button type="submit" class="btn btn-success">Generate & View Certificate</button>
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


    <!-- Give Marks Modal -->
    @foreach($students as $student)
    <div class="modal fade" id="generateIdMarks{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" action="{{ route('subadmin.marks.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Give Marks for {{ $student->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Student Info -->
                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                    <div class="mb-3 row">
                        <div class="col-4">
                            <label>Session From</label>
                            <input type="date" class="form-control" value="" name="session_from" required>
                        </div>
                        <div class="col-4">
                            <label>Session To</label>
                            <input type="date" class="form-control" value="" name="session_to" required>
                        </div>
                        <div class="col-4">
                            <label>Date of Issue</label>
                            <input type="date" class="form-control" value="" name="issue_date">
                        </div>
                    </div>

                    

                    <div class="mb-3">
                        <label>Student Name</label>
                        <input type="text" class="form-control" value="{{ $student->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Student Email</label>
                        <input type="email" class="form-control" value="{{ $student->email }}" readonly>
                    </div>

                    <!-- Assigned Courses -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Course <span class="text-danger">*</span></label>
                        <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                            @foreach($student->assigned_course_id as $course_id)
                            @php $course = $courses->where('id', $course_id)->first(); @endphp
                            @if($course)
                            <div class="form-check">
                                <input class="form-check-input course-select"
                                    type="radio"
                                    name="course_id"
                                    value="{{ $course->id }}"
                                    id="course_{{ $student->id }}_{{ $course->id }}"
                                    data-student="{{ $student->id }}"
                                    required>
                                <label class="form-check-label" for="course_{{ $student->id }}_{{ $course->id }}">
                                    {{ $course->course_name }}
                                </label>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Year Selection Container -->
                    <div id="yearContainer{{ $student->id }}" class="mb-3" style="display: none;">
                        <label class="form-label fw-bold">Select Year <span class="text-danger">*</span></label>
                        <select name="year" class="form-select year-select" data-student="{{ $student->id }}" required>
                            <option value="">Choose Year</option>
                        </select>
                    </div>

                    <!-- Subjects & Marks -->
                    <div id="subjectsContainer{{ $student->id }}" class="mt-3"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Marks</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach


    <!-- Download Marksheet(actually view) -->
    @foreach($students as $student)
    <div class="modal fade" id="downloadMarksheetIndividual{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Download Marksheet - {{ $student->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if(!empty($student->assigned_course_id))
                    @foreach($student->assigned_course_id as $courseId)
                    @php
                    $course = $courses->firstWhere('id', $courseId);
                    if (!$course) continue;

                    $duration = (int)$course->duration;
                    $years = floor($duration / 12);
                    $remainingMonths = $duration % 12;

                    // Get available marks for this student and course
                    $availableMarks = \App\Models\Mark::where('student_id', $student->id)
                    ->where('course_id', $courseId)
                    ->pluck('year')
                    ->toArray();
                    @endphp

                    @if(!empty($availableMarks))
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <strong>{{ $course->course_name }}</strong>
                            <small class="d-block">{{ $course->course_unique_id }} | Duration: {{ $course->duration }} Months</small>
                        </div>
                        <div class="card-body">
                            <label class="form-label fw-bold">Select Year/Duration:</label>

                            <div class="row">
                                @foreach($availableMarks as $yr)
                                @php
                                $label = "";
                                if ($duration < 12) {
                                    $label=$duration . " Month" . ($duration> 1 ? "s" : "");
                                    } else {
                                    if ($yr <= $years) {
                                        $label="Year " . $yr;
                                        } else if ($yr> $years && $remainingMonths > 0) {
                                        $label = $remainingMonths . " Month" . ($remainingMonths > 1 ? "s" : "");
                                        }
                                        }
                                        @endphp

                                        <div class="col-md-6 mb-2">
                                            <button type="button"
                                                class="btn btn-outline-primary w-100"
                                                onclick="viewMarksheet({{ $student->id }}, {{ $courseId }}, {{ $yr }})">
                                                <i class="bi bi-eye"></i> View {{ $label }} Marksheet
                                            </button>
                                        </div>
                                        @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        No marks available for <strong>{{ $course->course_name }}</strong>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        No courses assigned to this student.
                    </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
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


    <!-- Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Alert -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.querySelectorAll("#alert-container .alert").forEach(el => {
                    el.remove();
                });
            }, 2500);
        });
    </script>


    <!-- Select2 Course Filter Script -->
    <script>
        $(document).ready(function() {
            // Initialize Select2 with search enabled
            $('#courseSelect').select2({
                placeholder: 'Select courses',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#addStudentModal') // Important for modal
            });

            // Store all courses data
            const allCourses = @json($courses);

            // Load all courses initially
            allCourses.forEach(course => {
                $('#courseSelect').append(
                    `<option value="${course.id}">${course.course_name}</option>`
                );
            });

            // Filter courses when category changes
            $('#categorySelect').on('change', function() {
                const categoryId = $(this).val();

                // Clear current options
                $('#courseSelect').empty().trigger('change');

                if (categoryId) {
                    // Filter courses by selected category
                    const filteredCourses = allCourses.filter(course => course.category_id == categoryId);

                    // Add filtered courses to select
                    filteredCourses.forEach(course => {
                        const newOption = new Option(course.course_name, course.id, false, false);
                        $('#courseSelect').append(newOption);
                    });
                } else {
                    // If no category selected, show all courses
                    allCourses.forEach(course => {
                        const newOption = new Option(course.course_name, course.id, false, false);
                        $('#courseSelect').append(newOption);
                    });
                }

                // Refresh Select2 to show updated options
                $('#courseSelect').trigger('change');
            });
        });
    </script>

    <!-- Assign Marks -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // -----------------------------
            // Laravel Route Templates
            // -----------------------------
            const subjectUrlTemplate = "{{ route('subadmin.marks.subjects', ['course_id' => ':id']) }}";
            const marksUrlTemplate = "{{ route('subadmin.marks.get', ['student' => ':student', 'course' => ':course']) }}";

            // -----------------------------
            // COURSE SELECTION
            // -----------------------------
            document.querySelectorAll(".course-select").forEach(radio => {
                radio.addEventListener("change", async function() {

                    const courseId = this.value;
                    const studentId = this.dataset.student;

                    const yearContainer = document.getElementById("yearContainer" + studentId);
                    const yearSelect = yearContainer.querySelector(".year-select");
                    const subjectsContainer = document.getElementById("subjectsContainer" + studentId);

                    // Reset UI
                    yearSelect.innerHTML = '<option value="">Choose Year/Duration</option>';
                    subjectsContainer.innerHTML = "";
                    yearContainer.style.display = "none";

                    try {
                        // Fetch subjects
                        const fetchUrl = subjectUrlTemplate.replace(':id', courseId);
                        const subjectRes = await fetch(fetchUrl);

                        if (!subjectRes.ok) throw new Error("Failed to fetch subjects");

                        const data = await subjectRes.json();

                        const subjects = data.subjects || data;
                        const courseDuration = parseInt(data.duration ?? 0);

                        if (!subjects || Object.keys(subjects).length === 0) {
                            subjectsContainer.innerHTML =
                                "<p class='text-danger'>No subjects found for this course.</p>";
                            return;
                        }

                        // -----------------------------
                        // Duration Calculation
                        // -----------------------------
                        let durationInfo = null;

                        if (courseDuration > 0) {
                            durationInfo = {
                                totalMonths: courseDuration,
                                years: Math.floor(courseDuration / 12),
                                remainingMonths: courseDuration % 12,
                            };
                        }

                        // -----------------------------
                        // Populate Year/Month Dropdown
                        // -----------------------------
                        Object.keys(subjects).forEach(key => {
                            const option = document.createElement("option");
                            option.value = key;

                            let label = "";

                            if (durationInfo) {
                                if (durationInfo.totalMonths < 12) {
                                    label = `${durationInfo.totalMonths} Month${durationInfo.totalMonths > 1 ? "s" : ""}`;
                                } else {
                                    const keyNum = parseInt(key);
                                    if (keyNum <= durationInfo.years) {
                                        label = `Year ${keyNum}`;
                                    } else {
                                        label = `${durationInfo.remainingMonths} Month${durationInfo.remainingMonths > 1 ? "s" : ""}`;
                                    }
                                }
                            } else {
                                label = `Year ${key}`;
                            }

                            option.textContent = label;
                            option.dataset.durationLabel = label;
                            yearSelect.appendChild(option);
                        });

                        yearContainer.style.display = "block";

                        // store data
                        yearSelect.dataset.subjects = JSON.stringify(subjects);
                        yearSelect.dataset.durationInfo = JSON.stringify(durationInfo);

                    } catch (err) {
                        subjectsContainer.innerHTML =
                            "<p class='text-danger'>Error loading course data.</p>";
                        console.error(err);
                    }
                });
            });

            // -----------------------------
            // YEAR/DURATION SELECTION
            // -----------------------------
            document.querySelectorAll(".year-select").forEach(select => {
                select.addEventListener("change", async function() {
                    const year = this.value;
                    const studentId = this.dataset.student;

                    const subjectsContainer = document.getElementById("subjectsContainer" + studentId);
                    subjectsContainer.innerHTML = "";

                    if (!year) return;

                    subjectsContainer.innerHTML =
                        "<p class='text-muted'>Loading subjects...</p>";

                    try {
                        const allSubjects = JSON.parse(this.dataset.subjects);
                        const yearSubjects = Object.values(allSubjects[year] || {});

                        if (yearSubjects.length === 0) {
                            subjectsContainer.innerHTML =
                                `<p class="text-danger">No subjects found for this duration.</p>`;
                            return;
                        }

                        // Get selected course ID
                        const courseRadio = document.querySelector(
                            `input[name="course_id"][data-student="${studentId}"]:checked`
                        );
                        const courseId = courseRadio ? courseRadio.value : null;

                        let existingMarks = {};

                        // Fetch existing marks
                        if (courseId) {
                            const marksUrl = marksUrlTemplate
                                .replace(":student", studentId)
                                .replace(":course", courseId) + `?year=${year}`;

                            const marksRes = await fetch(marksUrl);
                            if (marksRes.ok) existingMarks = await marksRes.json();
                        }

                        // Get selected label
                        const selectedLabel =
                            this.options[this.selectedIndex].dataset.durationLabel ||
                            `Year ${year}`;

                        // -----------------------------
                        // Build Subject Inputs
                        // -----------------------------
                        let html = `
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>${selectedLabel}</strong> - Enter marks for all subjects
                    </div>
                    <div class="row">
                `;

                        yearSubjects.forEach(sub => {
                            const value = existingMarks[sub.subject_name] ?? "";

                            html += `
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                ${sub.subject_name}
                                <small class="text-muted">(Min: ${sub.min_marks}, Max: ${sub.max_marks})</small>
                            </label>
                            <input type="number"
                                   name="marks[${sub.subject_name}]"
                                   class="form-control"
                                   min="${sub.min_marks}"
                                   max="${sub.max_marks}"
                                   value="${value}"
                                   placeholder="Enter marks"
                                   required>
                        </div>
                    `;
                        });

                        html += "</div>";

                        subjectsContainer.innerHTML = html;

                    } catch (err) {
                        subjectsContainer.innerHTML =
                            "<p class='text-danger'>Error loading subjects or marks.</p>";
                        console.error(err);
                    }
                });
            });

            // -----------------------------
            // RESET MODAL ON CLOSE
            // -----------------------------
            document.querySelectorAll('[id^="generateIdMarks"]').forEach(modal => {
                modal.addEventListener("hidden.bs.modal", function() {
                    const studentId = this.id.replace("generateIdMarks", "");

                    document.getElementById("yearContainer" + studentId).style.display = "none";
                    document.getElementById("subjectsContainer" + studentId).innerHTML = "";
                    this.querySelector("form").reset();
                });
            });

        });
    </script>


    <!-- Search Student -->
    <script>
        document.getElementById('studentSearch').addEventListener('keyup', function() {
            let query = this.value.trim();

            if (query.length < 3) return;

            fetch("{{ route('subadmin.student.search') }}?query=" + query)
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById("studentResult").style.display = "block";
                        document.getElementById("resName").innerText = data.student.name;
                        document.getElementById("resEmail").innerText = data.student.email;
                        document.getElementById("resEnroll").innerText = data.student.enrollment_no;
                        document.getElementById("selectedStudentId").value = data.student.id;
                    } else {
                        document.getElementById("studentResult").style.display = "none";
                    }
                });
        });
    </script>

    <script>
        function viewMarksheet(studentId, courseId, year) {
            // Build the URL directly without using Laravel's route helper
            const url = '/subadmin/course-assign/marksheet/' + studentId + '/' + courseId + '?year=' + year;

            // Open in new tab
            window.open(url, '_blank');
        }
    </script>




</section>
@endsection