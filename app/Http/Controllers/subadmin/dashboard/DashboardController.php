<?php

namespace App\Http\Controllers\subadmin\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Mark;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    // Dashboard======================================================================================================>
    public function dashboard(Request $request)
    {
        return view('subadmin.dashboard.dashboard');
    }


    // Students=======================================================================================================>
    public function studentsView()
    {

        $students = Student::where('created_by', Auth::guard('subadmin')->id())->orderBy('id', 'desc')->get();
        return view('subadmin.student.index', compact('students'));
    }

    public function studentAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'created_by' => Auth::guard('subadmin')->id(),
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            $student = Student::findOrFail($id);
            $student->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
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
    public function courseAssignView()
    {
        $courses = Course::all();
        $sts = Student::where('created_by', Auth::guard('subadmin')->id())
            ->orderBy('id', 'desc')
            ->paginate(10);

        $students = Student::where('created_by', Auth::guard('subadmin')->id())
            ->whereNotNull('assigned_course_id')
            ->whereRaw("JSON_LENGTH(assigned_course_id) > 0")
            ->orderBy('id', 'desc')
            ->paginate(10);

        $assigned_courses = [];
        foreach ($students as $student) {
            $assigned_courses[$student->id] = $student->assigned_course_id;
        }

        return view('subadmin.courseassign.index', compact('courses', 'sts', 'students'));
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

            $student->assigned_course_id = [];
            $student->save();

            return redirect()->back()->with('success', 'Assigned courses removed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove assigned courses: ' . $e->getMessage());
        }
    }

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


        return view('subadmin.certificate.index', compact('student', 'course', 'marksObtainedInPercent'));
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
            'marks' => 'required|array',
        ]);

        $mark = Mark::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'course_id' => $validated['course_id'],
            ],
            [
                'marks' => $validated['marks'],
            ]
        );

        return redirect()->route('subadmin.marksheet.get', [
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id']
        ])->with('success', 'Marks saved successfully!');
    }

    public function getSubjects($course_id)
    {
        $course = Course::find($course_id);

        if (!$course || empty($course->subjects)) {
            return response()->json([]);
        }

        return response()->json(json_decode($course->subjects, true));
    }

    public function getStudentMarks($student_id, $course_id)
    {
        $mark = Mark::where('student_id', $student_id)
            ->where('course_id', $course_id)
            ->first();

        if (!$mark) return response()->json([]);

        return response()->json($mark->marks);
    }

    public function getMarksheet($student_id, $course_id)
    {
        $student = Student::findOrFail($student_id);
        $course = Course::findOrFail($course_id);

        $mark = Mark::where('student_id', $student_id)
            ->where('course_id', $course_id)
            ->first();

        if (!$mark) {
            return redirect()->back()->with('error', 'No marks found for this student.');
        }

        // Get subjects from course
        $subjects = json_decode($course->subjects, true);
        $marksData = $mark->marks;

        // Calculate subject-wise details
        $subjectDetails = [];
        $totalMarksObtained = 0;
        $totalMaxMarks = 0;

        foreach ($subjects as $subject) {
            $subjectName = $subject['subject_name'];
            $maxMarks = $subject['max_marks'];
            $obtainedMarks = $marksData[$subjectName] ?? 0;

            $percentage = ($maxMarks > 0) ? ($obtainedMarks / $maxMarks) * 100 : 0;

            // Calculate grade
            if ($percentage >= 90) {
                $grade = 'A+';
            } elseif ($percentage >= 80) {
                $grade = 'A';
            } elseif ($percentage >= 70) {
                $grade = 'B';
            } elseif ($percentage >= 60) {
                $grade = 'C';
            } elseif ($percentage >= 50) {
                $grade = 'D';
            } else {
                $grade = 'F';
            }

            $subjectDetails[] = [
                'name' => $subjectName,
                'max_marks' => $maxMarks,
                'obtained_marks' => $obtainedMarks,
                'percentage' => round($percentage, 2),
                'grade' => $grade
            ];

            $totalMarksObtained += $obtainedMarks;
            $totalMaxMarks += $maxMarks;
        }

        // Calculate overall percentage and grade
        $overallPercentage = ($totalMarksObtained / $totalMaxMarks) * 100;

        if ($overallPercentage >= 90) {
            $overallGrade = 'A+';
        } elseif ($overallPercentage >= 80) {
            $overallGrade = 'A';
        } elseif ($overallPercentage >= 70) {
            $overallGrade = 'B';
        } elseif ($overallPercentage >= 60) {
            $overallGrade = 'C';
        } elseif ($overallPercentage >= 50) {
            $overallGrade = 'D';
        } else {
            $overallGrade = 'F';
        }

        return view('subadmin.certificate.marksheet', compact(
            'student',
            'course',
            'subjectDetails',
            'totalMarksObtained',
            'totalMaxMarks',
            'overallPercentage',
            'overallGrade'
        ));
    }
}
