<?php

namespace App\Http\Controllers\subadmin\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    // Dashboard======================================================================================================>
    public function dashboard(Request $request)
    {
        return view('subadmin.dashboard.dashboard');
    }

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
}
