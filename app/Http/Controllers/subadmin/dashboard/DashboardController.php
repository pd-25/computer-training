<?php

namespace App\Http\Controllers\subadmin\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Course;
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
            // validate
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

            // Optionally: ensure provided course IDs are valid (exists check done in validation)
            $courseIds = array_values($request->assigned_course_id);

            // Save inside transaction
            DB::transaction(function () use ($student, $courseIds) {
                // store the array into JSON column
                $student->assigned_course_id = $courseIds;
                $student->save();

                // If you also need to create pivot records (student_course), add that logic here
                // e.g. $student->courses()->sync($courseIds);
            });

            return redirect()->back()->with('success', 'Courses assigned to student successfully.');
        } catch (\Exception $e) {
            // log exception if you want: \Log::error($e);
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

        // Return a dynamic certificate view
        return view('subadmin.certificate.index', compact('student', 'course'));
    }

    public function generateIdCard(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Return a dynamic ID card view
        return view('subadmin.idcard.index', compact('student'));
    }
}
