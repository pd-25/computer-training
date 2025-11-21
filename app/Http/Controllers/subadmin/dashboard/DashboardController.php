<?php

namespace App\Http\Controllers\subadmin\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Mark;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;


class DashboardController extends Controller
{


    // Dashboard======================================================================================================>
    public function dashboard(Request $request)
    {
        return view('subadmin.dashboard.dashboard');
    }


    // Students=======================================================================================================>
    public function studentsView(Request $request)
    {
        $search = $request->input('search');

        $students = Student::where('created_by', Auth::guard('subadmin')->id())
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('enrollment_no', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('father_name', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('subadmin.student.index', compact('students'));
    }

    // public function studentAdd(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:students,email',
    //         'phone' => 'required|string|max:15',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->with('error', $validator->errors()->first())->withInput();
    //     }

    //     try {
    //         Student::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'phone' => $request->phone,
    //             'created_by' => Auth::guard('subadmin')->id(),
    //         ]);
    //         return redirect()->back()->with('success', 'Student added successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Failed to add student: ' . $e->getMessage());
    //     }
    // }

    public function studentAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15',
            'father_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'admission_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('uploads/students'), $imageName);
                $imagePath = 'uploads/students/' . $imageName;
            }

            // Generate unique enrollment number (1st numbers, then letters; 6–15 chars)


            // Create student record
            $student = Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'father_name' => $request->father_name,
                'dob' => $request->dob,
                'admission_date' => $request->admission_date,
                'org_name' => Auth::guard('subadmin')->user()->org_name,
                'image' => $imagePath,
                'created_by' => Auth::guard('subadmin')->id(),
            ]);

            $prefix = "NITE000";
            $enrollmentNo = $prefix . $student->id;

            $student->update([
                'enrollment_no' => $enrollmentNo
            ]);

            return redirect()->back()->with('success', 'Student added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add student: ' . $e->getMessage());
        }
    }


    public function studentEdit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'required|string|max:15',
            'father_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'admission_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            $student = Student::findOrFail($id);

            // Handle image upload if provided
            $imagePath = $student->image;
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($student->image && file_exists(public_path($student->image))) {
                    unlink(public_path($student->image));
                }

                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('uploads/students'), $imageName);
                $imagePath = 'uploads/students/' . $imageName;
            }

            $student->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'father_name' => $request->father_name,
                'dob' => $request->dob,
                'admission_date' => $request->admission_date,
                'image' => $imagePath,
            ]);

            return redirect()->back()->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update student: ' . $e->getMessage());
        }
    }


    public function studentDelete($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            return redirect()->back()->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

    // Assaigned Courses===============================================================================================>
    // public function courseAssignView(Request $request)
    // {
    //     $search = $request->input('search');
    //     $categories = Category::all();

    //     // Get courses with their category_id
    //     $courses = Course::all();

    //     $sts = Student::where('created_by', Auth::guard('subadmin')->id())
    //         ->orderBy('id', 'desc')
    //         ->paginate(10);

    //     // Build the query with search functionality for assigned courses
    //     $students = Student::where('created_by', Auth::guard('subadmin')->id())
    //         ->whereNotNull('assigned_course_id')
    //         ->whereRaw("JSON_LENGTH(assigned_course_id) > 0")
    //         ->when($search, function ($query, $search) {
    //             return $query->where(function ($q) use ($search) {
    //                 $q->where('enrollment_no', 'like', '%' . $search . '%')
    //                     ->orWhere('name', 'like', '%' . $search . '%')
    //                     ->orWhere('email', 'like', '%' . $search . '%')
    //                     ->orWhere('phone', 'like', '%' . $search . '%');
    //             });
    //         })
    //         ->orderBy('id', 'desc')
    //         ->paginate(10)
    //         ->appends(['search' => $search]);

    //     $assigned_courses = [];
    //     foreach ($students as $student) {
    //         $assigned_courses[$student->id] = $student->assigned_course_id;
    //     }

    //     return view('subadmin.courseassign.index', compact('courses', 'sts', 'students', 'categories'));
    // }

    public function courseAssignView(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::all();
        $courses = Course::all();

        $sts = Student::where('created_by', Auth::guard('subadmin')->id())
            ->orderBy('id', 'desc')
            ->paginate(10);

        $students = Student::where('created_by', Auth::guard('subadmin')->id())
            ->whereNotNull('assigned_course_id')
            ->whereRaw("JSON_LENGTH(assigned_course_id) > 0")
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('enrollment_no', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        // ===========================
        //  Get available YEARS
        // ===========================
        $availableYears = [];

        foreach ($students as $student) {
            $years = [];

            $assignedCourses = is_array($student->assigned_course_id)
                ? $student->assigned_course_id
                : json_decode($student->assigned_course_id, true);


            if (!empty($assignedCourses)) {
                foreach ($assignedCourses as $courseId) {
                    $yrs = Mark::where('student_id', $student->id)
                        ->where('course_id', $courseId)
                        ->pluck('year')
                        ->unique()
                        ->values();

                    if ($yrs->count() > 0) {
                        $years[$courseId] = $yrs; // store years for that course
                    }
                }
            }

            $availableYears[$student->id] = $years;
        }

        return view('subadmin.courseassign.index', compact(
            'courses',
            'sts',
            'students',
            'categories',
            'availableYears'
        ));
    }

    public function searchStudent(Request $request)
    {
        $query = $request->query('query');

        $student = Student::where('created_by', Auth::guard('subadmin')->id())
            ->where(function ($q) use ($query) {
                $q->where('email', 'LIKE', "%$query%")
                    ->orWhere('enrollment_no', 'LIKE', "%$query%");
            })
            ->first();

        if (!$student) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json([
            'status' => 'success',
            'student' => $student
        ]);
    }

    public function courseAssignAdd(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'student_id' => 'required|exists:students,id',
                'assigned_course_id' => 'required|array|min:1',
                'assigned_course_id.*' => 'required|distinct|integer|exists:courses,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $student = Student::findOrFail($request->student_id);

            $courseIds = array_values($request->assigned_course_id);

            DB::transaction(function () use ($student, $courseIds) {

                $student->assigned_course_id = $courseIds;
                $student->save();
            });

            return redirect()->back()->with('success', 'Courses assigned to student successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to assign courses: ' . $e->getMessage());
        }
    }

    public function courseAssignEdit(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'assigned_course_id' => 'required|array|min:1',
                'assigned_course_id.*' => 'required|integer|exists:courses,id|distinct',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $student = Student::findOrFail($id);
            $courseIds = array_values($request->assigned_course_id);

            DB::transaction(function () use ($student, $courseIds) {
                $student->assigned_course_id = $courseIds;
                $student->save();
            });

            return redirect()->back()->with('success', 'Student courses updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update courses: ' . $e->getMessage());
        }
    }

    public function courseAssignDelete($id)
    {
        try {
            $student = Student::findOrFail($id);

            // Delete marks for this student
            Mark::where('student_id', $id)->delete();

            // Clear assigned courses
            $student->assigned_course_id = [];
            $student->save();

            return redirect()->back()->with('success', 'Assigned courses and marks removed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove assigned courses: ' . $e->getMessage());
        }
    }

    // public function generateCertificate(Request $request)
    // {
    //     $request->validate([
    //         'student_id' => 'required|exists:students,id',
    //         'course_id' => 'required|exists:courses,id',
    //     ]);

    //     $student = Student::findOrFail($request->student_id);
    //     $course = Course::findOrFail($request->course_id);


    //     // Calculate marks obtained in percentage
    //     $marksObtainedInPercent = 0;

    //     $mark = Mark::where('student_id', $student->id)
    //         ->where('course_id', $course->id)
    //         ->first();

    //     $course = Course::find($course->id);

    //     if ($mark && $course) {
    //         $subjects = json_decode($course->subjects, true);
    //         $marks = is_array($mark->marks) ? $mark->marks : json_decode($mark->marks, true);

    //         $totalObtained = 0;
    //         $totalMax = 0;

    //         foreach ($subjects as $sub) {
    //             $subName = $sub['subject_name'];
    //             $maxMarks = isset($sub['max_marks']) ? (int)$sub['max_marks'] : 100;

    //             $obtained = isset($marks[$subName]) ? (int)$marks[$subName] : 0;

    //             $totalObtained += $obtained;
    //             $totalMax += $maxMarks;
    //         }

    //         if ($totalMax > 0) {
    //             $marksObtainedInPercent = round(($totalObtained / $totalMax) * 100, 2);
    //         }
    //     }


    //     return view('subadmin.certificate.index', compact('student', 'course', 'marksObtainedInPercent'));
    // }

    public function generateCertificate(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = Student::findOrFail($request->student_id);
        $course = Course::findOrFail($request->course_id);

        // Calculate marks obtained in percentage
        $marksObtainedInPercent = 0;

        $mark = Mark::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        $course = Course::find($course->id);

        if ($mark && $course) {
            $subjects = json_decode($course->subjects, true);
            $marks = is_array($mark->marks) ? $mark->marks : json_decode($mark->marks, true);

            $totalObtained = 0;
            $totalMax = 0;

            foreach ($subjects as $sub) {
                $subName = $sub['subject_name'];
                $maxMarks = isset($sub['max_marks']) ? (int)$sub['max_marks'] : 100;

                $obtained = isset($marks[$subName]) ? (int)$marks[$subName] : 0;

                $totalObtained += $obtained;
                $totalMax += $maxMarks;
            }

            if ($totalMax > 0) {
                $marksObtainedInPercent = round(($totalObtained / $totalMax) * 100, 2);
            }
        }

        $certificateUrl = route('certificate.public.show', [
            'student_id' => $student->id,
            'course_id' => $course->id
        ]);

        // Build QR Code (v6 correct syntax)
        $result = (new Builder(
            writer: new PngWriter(),
            data: $certificateUrl,
            size: 120,
            margin: 10,
        ))->build();

        // Convert to Base64
        $qrCodeBase64 = base64_encode($result->getString());

        return view('subadmin.certificate.index', compact(
            'student',
            'course',
            'marksObtainedInPercent',
            'qrCodeBase64'
        ));
    }

    public function showPublicCertificate($student_id, $course_id)
    {
        $student = Student::findOrFail($student_id);
        $course = Course::findOrFail($course_id);

        // Calculate marks obtained in percentage
        $marksObtainedInPercent = 0;

        $mark = Mark::where('student_id', $student_id)
            ->where('course_id', $course_id)
            ->first();

        if ($mark && $course) {
            $subjects = json_decode($course->subjects, true);
            $marks = is_array($mark->marks) ? $mark->marks : json_decode($mark->marks, true);

            $totalObtained = 0;
            $totalMax = 0;

            foreach ($subjects as $sub) {
                $subName = $sub['subject_name'];
                $maxMarks = isset($sub['max_marks']) ? (int)$sub['max_marks'] : 100;

                $obtained = isset($marks[$subName]) ? (int)$marks[$subName] : 0;

                $totalObtained += $obtained;
                $totalMax += $maxMarks;
            }

            if ($totalMax > 0) {
                $marksObtainedInPercent = round(($totalObtained / $totalMax) * 100, 2);
            }
        }

        // Don't generate QR code for public view (to avoid recursion)
        $qrCode = null;

        return view('subadmin.certificate.index', compact('student', 'course', 'marksObtainedInPercent', 'qrCode'));
    }


    public function generateIdCard(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = Student::findOrFail($request->student_id);
        $course = Course::findOrFail($request->course_id);

        return view('subadmin.idcard.index', compact('student', 'course'));
    }

    public function giveMarks(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer',
            'course_id' => 'required|integer',
            'year' => 'required|integer|min:1',
            'marks' => 'required|array',
        ]);

        $mark = Mark::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'course_id' => $validated['course_id'],
                'year' => $validated['year'],
            ],
            [
                'marks' => $validated['marks'],
            ]
        );

        return redirect()->route('subadmin.marksheet.get', [
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'year' => $validated['year']
        ])->with('success', 'Marks saved successfully for Year ' . $validated['year'] . '!');
    }

    public function getSubjects($course_id)
    {
        $course = Course::find($course_id);

        if (!$course || empty($course->subjects)) {
            return response()->json([]);
        }

        // Return subjects grouped by year
        return response()->json(json_decode($course->subjects, true));
    }

    public function getStudentMarks($student_id, $course_id, $year = null)
    {
        $query = Mark::where('student_id', $student_id)
            ->where('course_id', $course_id);

        if ($year) {
            $query->where('year', $year);
        }

        $marks = $query->get();

        if ($marks->isEmpty()) {
            return response()->json([]);
        }

        // If specific year requested, return that year's marks
        if ($year) {
            return response()->json($marks->first()->marks ?? []);
        }

        // Otherwise return all years' marks
        $allMarks = [];
        foreach ($marks as $mark) {
            $allMarks[$mark->year] = $mark->marks;
        }

        return response()->json($allMarks);
    }

    public function getMarksheet($student_id, $course_id, $year = null)
    {
        $student = Student::findOrFail($student_id);
        $course = Course::findOrFail($course_id);

        // Get subjects from course
        $courseSubjects = json_decode($course->subjects, true);

        if (!$courseSubjects) {
            return redirect()->back()->with('error', 'No subjects found for this course.');
        }

        // If year is specified, show only that year
        if ($year) {
            $mark = Mark::where('student_id', $student_id)
                ->where('course_id', $course_id)
                ->where('year', $year)
                ->first();

            if (!$mark) {
                return redirect()->back()->with('error', 'No marks found for Year ' . $year);
            }

            $subjects = $courseSubjects[$year] ?? [];
            $marksData = $mark->marks;

            $subjectDetails = $this->calculateSubjectDetails($subjects, $marksData);
            $totalMarksObtained = array_sum(array_column($subjectDetails, 'obtained_marks'));
            $totalMaxMarks = array_sum(array_column($subjectDetails, 'max_marks'));
            $overallPercentage = ($totalMaxMarks > 0) ? ($totalMarksObtained / $totalMaxMarks) * 100 : 0;
            $overallGrade = $this->calculateGrade($overallPercentage);

            return view('subadmin.certificate.marksheet', compact(
                'student',
                'course',
                'subjectDetails',
                'totalMarksObtained',
                'totalMaxMarks',
                'overallPercentage',
                'overallGrade',
                'year'
            ));
        }

        // Show all years
        $allYearsData = [];
        $grandTotalObtained = 0;
        $grandTotalMax = 0;

        foreach ($courseSubjects as $yearNum => $subjects) {
            $mark = Mark::where('student_id', $student_id)
                ->where('course_id', $course_id)
                ->where('year', $yearNum)
                ->first();

            if (!$mark) continue;

            $marksData = $mark->marks;
            $subjectDetails = $this->calculateSubjectDetails($subjects, $marksData);

            $totalMarksObtained = array_sum(array_column($subjectDetails, 'obtained_marks'));
            $totalMaxMarks = array_sum(array_column($subjectDetails, 'max_marks'));
            $yearPercentage = ($totalMaxMarks > 0) ? ($totalMarksObtained / $totalMaxMarks) * 100 : 0;

            $allYearsData[$yearNum] = [
                'subjects' => $subjectDetails,
                'total_obtained' => $totalMarksObtained,
                'total_max' => $totalMaxMarks,
                'percentage' => $yearPercentage,
                'grade' => $this->calculateGrade($yearPercentage)
            ];

            $grandTotalObtained += $totalMarksObtained;
            $grandTotalMax += $totalMaxMarks;
        }

        $grandPercentage = ($grandTotalMax > 0) ? ($grandTotalObtained / $grandTotalMax) * 100 : 0;
        $grandGrade = $this->calculateGrade($grandPercentage);

        return view('subadmin.certificate.marksheet', compact(
            'student',
            'course',
            'allYearsData',
            'grandTotalObtained',
            'grandTotalMax',
            'grandPercentage',
            'grandGrade',
            'year'
        ));
    }

    // Helper function to calculate subject details
    private function calculateSubjectDetails($subjects, $marksData)
    {
        $subjectDetails = [];

        foreach ($subjects as $subject) {
            $subjectName = $subject['subject_name'];
            $maxMarks = $subject['max_marks'];
            $obtainedMarks = $marksData[$subjectName] ?? 0;

            $percentage = ($maxMarks > 0) ? ($obtainedMarks / $maxMarks) * 100 : 0;
            $grade = $this->calculateGrade($percentage);

            $subjectDetails[] = [
                'name' => $subjectName,
                'max_marks' => $maxMarks,
                'min_marks' => $subject['min_marks'] ?? 0,
                'obtained_marks' => $obtainedMarks,
                'percentage' => round($percentage, 2),
                'grade' => $grade
            ];
        }

        return $subjectDetails;
    }

    // Helper function to calculate grade
    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        return 'F';
    }
}
