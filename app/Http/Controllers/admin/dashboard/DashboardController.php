<?php

namespace App\Http\Controllers\admin\dashboard;


use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;
use App\Models\FranchiseRequest;
use App\Models\Mark;
use App\Models\Student;
use App\Models\SubAdmin as ModelsSubAdmin;
use App\Models\TopupRequest;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


    // Dashboard======================================================================================================>
    public function dashboard(Request $request)
    {
        $totalFranchise = ModelsSubAdmin::count();
        return view('admin.dashboard.dashboard', compact('totalFranchise'));
    }


    // Category======================================================================================================>
    public function categoryView()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(1);
        return view('admin.category.index', compact('categories'));
    }

    public function categoryAdd(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:categories,name',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3048', // validation for image
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->slug = Str::slug($request->name, '-');

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('categories', 'public');
                $category->image = $path;
            }

            $category->save();

            return redirect()->back()->with('success', 'Category added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add category: ' . $e->getMessage());
        }
    }

    public function categoryEdit(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:categories,name,' . $id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3048',
            ]);

            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->slug = Str::slug($request->name, '-');

            if ($request->hasFile('image')) {

                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                $path = $request->file('image')->store('categories', 'public');
                $category->image = $path;
            }

            $category->save();

            return redirect()->back()->with('success', 'Category updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function categoryDelete($id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();
            return redirect()->back()->with('success', 'Category deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    // Course======================================================================================================>
    public function courseView(Request $request)
    {
        $categories = Category::all();

        // Get the search query from the request
        $search = $request->input('search');

        // Build the query with search functionality
        $courses = Course::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('course_name', 'like', '%' . $search . '%')
                    ->orWhere('course_unique_id', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.course.index', compact('categories', 'courses'));
    }

    public function courseAdd(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'course_name' => 'required|string|unique:courses,course_name',
                'price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'duration' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3048',
                'subjects' => 'required|array|min:1',
                'subjects.*' => 'required|array',
                'subjects.*.*.subject_name' => 'required|string',
                'subjects.*.*.min_marks' => 'required|numeric|min:0',
                'subjects.*.*.max_marks' => 'required|numeric|min:0',
            ]);

            $course = new Course();
            $course->category_id = $request->category_id;
            $course->course_name = $request->course_name;
            $course->price = $request->price;
            $course->slug = Str::slug($request->course_name, '-');
            $course->description = $request->description;
            $course->duration = $request->duration;

            // Handle image
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('courses', 'public');
                $course->image = $path;
            }

            // Save subjects as JSON
            $course->subjects = json_encode($request->subjects);

            $course->save();

            // Course Unique ID generation
            $prefix = "NITE000";
            $uniqueId = $prefix . $course->id;

            $course->update([
                'course_unique_id' => $uniqueId
            ]);

            return redirect()->back()->with('success', 'Course added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add course: ' . $e->getMessage());
        }
    }

    public function courseEdit(Request $request, $id)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'course_name' => 'required|string|unique:courses,course_name,' . $id,
                'price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'duration' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3048',
                'subjects' => 'required|array|min:1',
                'subjects.*' => 'required|array',
                'subjects.*.*.subject_name' => 'required|string',
                'subjects.*.*.min_marks' => 'required|numeric|min:0',
                'subjects.*.*.max_marks' => 'required|numeric|min:0',
            ]);

            $course = Course::findOrFail($id);

            $course->category_id = $request->category_id;
            $course->course_name = $request->course_name;
            $course->price = $request->price;
            $course->slug = Str::slug($request->course_name, '-');
            $course->description = $request->description;
            $course->duration = $request->duration;

            // Handle image
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($course->image && Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }

                $path = $request->file('image')->store('courses', 'public');
                $course->image = $path;
            }

            // Save subjects as JSON
            $course->subjects = json_encode($request->subjects);

            $course->save();

            return redirect()->back()->with('success', 'Course updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update course: ' . $e->getMessage());
        }
    }

    public function courseDelete($id)
    {
        try {
            $course = Course::findOrFail($id);

            // Delete image if exists
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }

            $course->delete();

            return redirect()->back()->with('success', 'Course deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete course: ' . $e->getMessage());
        }
    }


    // Sub admins===================================================================================================>
    public function subadminView(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        // Build the query with search functionality
        $subAdmins = ModelsSubAdmin::query()
            ->when($search, function ($query, $search) {
                return $query->where('org_name', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('subadmin_unique_id', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]); // Preserve search parameter in pagination

        return view('admin.subadmin.index', compact('subAdmins'));
    }

    public function addSubAdmin(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'org_name' => 'required|string|max:255',
            'email' => 'required|email|unique:sub_admins,email',
            'password' => 'required|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        try {
            $subAdmin = ModelsSubAdmin::create([
                'name' => $request->name,
                'org_name' => $request->org_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // Generate unique course ID in format NITE-00 + id
            $prefix = "NITE-00";
            $uniqueId = $prefix . $subAdmin->id;

            $subAdmin->update([
                'subadmin_unique_id' => $uniqueId
            ]);

            return redirect()->back()->with('success', 'Franchise added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add Franchise: ' . $e->getMessage());
        }
    }

    public function editSubAdmin(Request $request, $id)
    {
        $subAdmin = ModelsSubAdmin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'org_name' => 'required|string|max:255',
            'email' => 'required|email|unique:sub_admins,email,' . $subAdmin->id,
            'password' => 'nullable|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        try {
            $subAdmin->name = $request->name;
            $subAdmin->org_name = $request->org_name;
            $subAdmin->email = $request->email;

            if (!empty($request->password)) {
                $subAdmin->password = bcrypt($request->password);
            }

            $subAdmin->save();

            return redirect()->back()->with('success', 'Franchise updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Franchise: ' . $e->getMessage());
        }
    }

    public function deleteSubAdmin($id)
    {
        try {
            $subAdmin = ModelsSubAdmin::findOrFail($id);
            $subAdmin->delete();

            return redirect()->back()->with('success', 'Franchise deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Franchise: ' . $e->getMessage());
        }
    }

    public function loginAsSubAdmin($id)
    {
        $subAdmin = \App\Models\SubAdmin::findOrFail($id);

        session(['admin_id' => Auth::guard('admin')->id()]);

        Auth::guard('subadmin')->login($subAdmin);

        return redirect()->route('subadmin.dashboard');
    }

    public function returnToAdmin()
    {

        $adminId = session('admin_id');

        if ($adminId) {

            Auth::logout();

            Auth::guard('admin')->loginUsingId($adminId);
            session()->forget('admin_id');

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    }



    // Students===================================================================================================>
    public function studentsView(Request $request)
    {
        $subadmins = ModelsSubAdmin::all();

        // Get the search query from the request
        $search = $request->input('search');

        // Build the query with search functionality
        $students = Student::with('subadmin')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]); // Preserve search parameter in pagination

        return view('admin.student.index', compact('subadmins', 'students'));
    }

    public function studentAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:students,email',
            'phone'      => 'required|string|max:15',
            'created_by' => 'required|exists:sub_admins,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            Student::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'created_by' => $request->created_by,
            ]);
            return redirect()->back()->with('success', 'Student added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add student: ' . $e->getMessage());
        }
    }

    public function studentEdit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:students,email,' . $id,
            'phone'      => 'required|string|max:15',
            'created_by' => 'required|exists:sub_admins,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            $student = Student::findOrFail($id);
            $student->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'created_by' => $request->created_by,
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

    public function franchiseView()
    {
        $franchises = FranchiseRequest::latest()->get();
        return view('admin.franchise.index', compact('franchises'));
    }

    public function acceptFranchise($id)
    {
        try {
            $franchise = FranchiseRequest::findOrFail($id);
            $franchise->status = 'approved';
            $franchise->save();

            // Check if a SubAdmin with this email already exists
            $existingSubAdmin = ModelsSubAdmin::where('email', $franchise->email)->first();

            if (!$existingSubAdmin) {
                // Create a new SubAdmin with default password
                $subadmin = ModelsSubAdmin::create([
                    'name' => $franchise->name,
                    'email' => $franchise->email,
                    'org_name' => $franchise->experience,
                    'password' => Hash::make('12345678'),
                ]);

                // Generate unique course ID in format NITE-00 + id
                $prefix = "NITE-00";
                $uniqueId = $prefix . $subadmin->id;

                // Save unique ID to the subadmin record
                $subadmin->subadmin_unique_id = $uniqueId;
                $subadmin->save();
            }

            // Optional: Send acceptance email
            /*
        Mail::send('emails.franchise-accepted', ['data' => $franchise], function($message) use ($franchise) {
            $message->to($franchise->email)
                ->subject('Franchise Application Approved');
        });
        */

            return redirect()->back()->with('success', 'Franchise request approved and SubAdmin created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to approve franchise request. ' . $e->getMessage());
        }
    }

    public function rejectFranchise(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'nullable|string|max:500'
        ]);

        try {
            $franchise = FranchiseRequest::findOrFail($id);
            $franchise->status = 'rejected';
            $franchise->reject_reason = $request->reject_reason;
            $franchise->save();

            // Send rejection email (optional)
            /*
            Mail::send('emails.franchise-rejected', ['data' => $franchise], function($message) use ($franchise) {
                $message->to($franchise->email)
                    ->subject('Franchise Application Update');
            });
            */

            return redirect()->back()->with('success', 'Franchise request rejected.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reject franchise request.');
        }
    }

    public function deleteFranchise($id)
    {
        try {
            $franchise = FranchiseRequest::findOrFail($id);
            $franchise->delete();

            return redirect()->back()->with('success', 'Franchise request deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete franchise request.');
        }
    }

    public function viewFranchiseDetails($id)
    {
        $franchise = FranchiseRequest::findOrFail($id);
        return view('admin.franchise.view', compact('franchise'));
    }



    // Payments Requests===============================================================================================>
    public function paymentsView()
    {
        $totalPayments = TopupRequest::with('subadmin')->orderBy('id', 'desc')->paginate(10);

        return view('admin.payments.index', compact('totalPayments'));
    }

    public function paymentAccept(Request $request, $id)
    {
        $request->validate([
            'subadmin_id' => 'required|exists:sub_admins,id',
            'amount' => 'required|numeric|min:0',
        ]);

        try {

            DB::beginTransaction();

            // 1. Approve payment request
            $paymentRequest = TopupRequest::findOrFail($id);
            $paymentRequest->status = 'approved';
            $paymentRequest->save();

            // 2. Credit amount to wallet
            $wallet = Wallet::firstOrCreate(
                ['subadmin_id' => $request->subadmin_id],
                ['amount' => 0]
            );

            // Add the amount
            $wallet->amount += $request->amount;
            $wallet->save();

            DB::commit();

            return redirect()->back()->with('success', 'Payment request approved & wallet credited.');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to approve payment request: ' . $e->getMessage());
        }
    }

    public function paymentRejected(Request $request, $id)
    {
        try {
            $paymentRequest = TopupRequest::findOrFail($id);
            $paymentRequest->status = 'rejected';
            $paymentRequest->save();

            return redirect()->back()->with('success', 'Payment request rejected.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reject payment request: ' . $e->getMessage());
        }
    }

    public function deletePaymentRequest($id)
    {
        try {
            $paymentRequest = TopupRequest::findOrFail($id);
            $paymentRequest->delete();

            return redirect()->back()->with('success', 'Payment request deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete payment request.');
        }
    }



    // Course Assigned Students ============================================================================================================>
    public function courseAssignedAllStudentsShow(Request $request)
    {
        $search = $request->input('search');

        // Get all students with assigned courses from all subadmins
        $students = Student::whereNotNull('assigned_course_id')
            ->whereRaw("JSON_LENGTH(assigned_course_id) > 0")
            ->with(['subadmin']) // Eager load subadmin relationship
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('enrollment_no', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhereHas('subadmin', function ($sq) use ($search) {
                            $sq->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        $courses = Course::all();
        $categories = Category::all();

        // Get available years for each student
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
                        $years[$courseId] = $yrs;
                    }
                }
            }
            $availableYears[$student->id] = $years;
        }

        return view('admin.student.assigned-students', compact(
            'students',
            'courses',
            'categories',
            'availableYears',
        ));
    }

    public function showIdCard($student_id, $course_id)
    {
        $student = Student::findOrFail($student_id);
        $course = Course::findOrFail($course_id);

        return view('subadmin.idcard.index', compact('student', 'course'));
    }

    // public function showMarkSheet($student_id, $course_id)
    // {
    //     $student = Student::findOrFail($student_id);
    //     $course = Course::findOrFail($course_id);

    //     $year = request()->get('year');

    //     // Get subjects from course
    //     $courseSubjects = json_decode($course->subjects, true);

    //     if (!$courseSubjects) {
    //         return redirect()->back()->with('error', 'No subjects found for this course.');
    //     }

    //     // IF YEAR IS SPECIFIED - SHOW ONLY THAT YEAR
    //     if ($year !== null && $year != '') {
    //         $mark = Mark::where('student_id', $student_id)
    //             ->where('course_id', $course_id)
    //             ->where('year', $year)
    //             ->first();

    //         if (!$mark) {
    //             return redirect()->back()->with('error', 'No marks found for Year ' . $year);
    //         }

    //         $subjects = $courseSubjects[$year] ?? [];

    //         if (empty($subjects)) {
    //             return redirect()->back()->with('error', 'No subjects found for Year ' . $year);
    //         }

    //         $marksData = $mark->marks;
    //         $subjectDetails = $this->calculateSubjectDetails($subjects, $marksData);
    //         $totalMarksObtained = array_sum(array_column($subjectDetails, 'obtained_marks'));
    //         $totalMaxMarks = array_sum(array_column($subjectDetails, 'max_marks'));
    //         $overallPercentage = ($totalMaxMarks > 0) ? ($totalMarksObtained / $totalMaxMarks) * 100 : 0;
    //         $overallGrade = $this->calculateGrade($overallPercentage);

    //         return view('subadmin.certificate.marksheet', compact(
    //             'student',
    //             'course',
    //             'subjectDetails',
    //             'totalMarksObtained',
    //             'totalMaxMarks',
    //             'overallPercentage',
    //             'overallGrade',
    //             'year',
    //             'mark'
    //         ));
    //     }

    //     // IF NO YEAR - SHOW ALL YEARS
    //     $allYearsData = [];
    //     $grandTotalObtained = 0;
    //     $grandTotalMax = 0;

    //     foreach ($courseSubjects as $yearNum => $subjects) {
    //         $mark = Mark::where('student_id', $student_id)
    //             ->where('course_id', $course_id)
    //             ->where('year', $yearNum)
    //             ->first();

    //         if (!$mark) continue;

    //         $marksData = $mark->marks;
    //         $subjectDetails = $this->calculateSubjectDetails($subjects, $marksData);

    //         $totalMarksObtained = array_sum(array_column($subjectDetails, 'obtained_marks'));
    //         $totalMaxMarks = array_sum(array_column($subjectDetails, 'max_marks'));
    //         $yearPercentage = ($totalMaxMarks > 0) ? ($totalMarksObtained / $totalMaxMarks) * 100 : 0;

    //         $allYearsData[$yearNum] = [
    //             'subjects' => $subjectDetails,
    //             'total_obtained' => $totalMarksObtained,
    //             'total_max' => $totalMaxMarks,
    //             'percentage' => $yearPercentage,
    //             'grade' => $this->calculateGrade($yearPercentage)
    //         ];

    //         $grandTotalObtained += $totalMarksObtained;
    //         $grandTotalMax += $totalMaxMarks;
    //     }

    //     $grandPercentage = ($grandTotalMax > 0) ? ($grandTotalObtained / $grandTotalMax) * 100 : 0;
    //     $grandGrade = $this->calculateGrade($grandPercentage);

    //     return view('subadmin.certificate.marksheet', compact(
    //         'student',
    //         'course',
    //         'allYearsData',
    //         'grandTotalObtained',
    //         'grandTotalMax',
    //         'grandPercentage',
    //         'grandGrade'
    //     ));
    // }

    // public function showCertificate($student_id, $course_id)
    // {
    //     $student = Student::findOrFail($student_id);
    //     $course = Course::findOrFail($course_id);

    //     // Get all subjects for this course
    //     $courseSubjects = json_decode($course->subjects, true);

    //     if (!$courseSubjects) {
    //         return redirect()->back()->with('error', 'No subjects found for this course.');
    //     }

    //     // Get ALL marks for this student and course (all years)
    //     $allMarks = Mark::where('student_id', $student->id)
    //         ->where('course_id', $course->id)
    //         ->get();

    //     if ($allMarks->isEmpty()) {
    //         return redirect()->back()->with('error', 'No marks found for this student in this course.');
    //     }

    //     // Calculate total marks across ALL years
    //     $grandTotalObtained = 0;
    //     $grandTotalMax = 0;
    //     $yearWiseData = [];

    //     foreach ($allMarks as $mark) {
    //         $year = $mark->year;
    //         $subjects = $courseSubjects[$year] ?? [];

    //         if (empty($subjects)) continue;

    //         $marksData = is_array($mark->marks) ? $mark->marks : json_decode($mark->marks, true);

    //         $yearObtained = 0;
    //         $yearMax = 0;

    //         foreach ($subjects as $subject) {
    //             $subName = $subject['subject_name'];
    //             $maxMarks = isset($subject['max_marks']) ? (int)$subject['max_marks'] : 100;
    //             $obtained = isset($marksData[$subName]) ? (int)$marksData[$subName] : 0;

    //             $yearObtained += $obtained;
    //             $yearMax += $maxMarks;
    //         }

    //         $grandTotalObtained += $yearObtained;
    //         $grandTotalMax += $yearMax;

    //         $yearWiseData[$year] = [
    //             'obtained' => $yearObtained,
    //             'max' => $yearMax,
    //             'percentage' => ($yearMax > 0) ? round(($yearObtained / $yearMax) * 100, 2) : 0
    //         ];
    //     }

    //     // Calculate overall percentage
    //     $marksObtainedInPercent = ($grandTotalMax > 0)
    //         ? round(($grandTotalObtained / $grandTotalMax) * 100, 2)
    //         : 0;

    //     // Calculate grade
    //     $grade = $this->calculateGrade($marksObtainedInPercent);

    //     // Generate QR Code for certificate verification
    //     $certificateUrl = route('certificate.public.show', [
    //         'student_id' => $student->id,
    //         'course_id' => $course->id
    //     ]);

    //     $result = (new Builder(
    //         writer: new PngWriter(),
    //         data: $certificateUrl,
    //         size: 120,
    //         margin: 10,
    //     ))->build();

    //     $qrCodeBase64 = base64_encode($result->getString());
        

    //     return view('subadmin.certificate.index', compact(
    //         'student',
    //         'course',
    //         'marksObtainedInPercent',
    //         'grandTotalObtained',
    //         'grandTotalMax',
    //         'grade',
    //         'yearWiseData',
    //         'qrCodeBase64',
    //         'mark'
    //     ));
    // }

    public function showMarkSheet($student_id, $course_id)
{
    $student = Student::findOrFail($student_id);
    $course = Course::findOrFail($course_id);

    $year = request()->get('year');

    $courseSubjects = json_decode($course->subjects, true);

    if (!$courseSubjects) {
        return redirect()->back()->with('error', 'No subjects found for this course.');
    }

    if ($year !== null && $year != '') {
        $mark = Mark::where('student_id', $student_id)
            ->where('course_id', $course_id)
            ->where('year', $year)
            ->first();

        if (!$mark) {
            return redirect()->back()->with('error', 'No marks found for Year ' . $year);
        }

        // ← save dates from query string if provided
        if (request()->has('session_from')) {
            $mark->update([
                'session_from' => request()->get('session_from'),
                'session_to'   => request()->get('session_to'),
                'issue_date'   => request()->get('issue_date'),
            ]);
            $mark->refresh();
        }

        $subjects = $courseSubjects[$year] ?? [];

        if (empty($subjects)) {
            return redirect()->back()->with('error', 'No subjects found for Year ' . $year);
        }

        $marksData = $mark->marks;
        $subjectDetails = $this->calculateSubjectDetails($subjects, $marksData);
        $totalMarksObtained = array_sum(array_column($subjectDetails, 'obtained_marks'));
        $totalMaxMarks = array_sum(array_column($subjectDetails, 'max_marks'));
        $overallPercentage = ($totalMaxMarks > 0) ? ($totalMarksObtained / $totalMaxMarks) * 100 : 0;
        $overallGrade = $this->calculateGrade($overallPercentage);

        $session_from = $mark->session_from;
        $session_to   = $mark->session_to;
        $issue_date   = $mark->issue_date;

        return view('subadmin.certificate.marksheet', compact(
            'student',
            'course',
            'subjectDetails',
            'totalMarksObtained',
            'totalMaxMarks',
            'overallPercentage',
            'overallGrade',
            'year',
            'mark',
            'session_from',
            'session_to',
            'issue_date'
        ));
    }

    // IF NO YEAR - SHOW ALL YEARS
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
            'subjects'       => $subjectDetails,
            'total_obtained' => $totalMarksObtained,
            'total_max'      => $totalMaxMarks,
            'percentage'     => $yearPercentage,
            'grade'          => $this->calculateGrade($yearPercentage),
            'session_from'   => $mark->session_from,
            'session_to'     => $mark->session_to,
            'issue_date'     => $mark->issue_date,
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
        'grandGrade'
    ));
}

public function showCertificate($student_id, $course_id)
{
    $student = Student::findOrFail($student_id);
    $course = Course::findOrFail($course_id);

    $courseSubjects = json_decode($course->subjects, true);

    if (!$courseSubjects) {
        return redirect()->back()->with('error', 'No subjects found for this course.');
    }

    $allMarks = Mark::where('student_id', $student->id)
        ->where('course_id', $course->id)
        ->get();

    if ($allMarks->isEmpty()) {
        return redirect()->back()->with('error', 'No marks found for this student in this course.');
    }

    // ← save issue_date_certificate from query string if provided
    if (request()->has('issue_date_certificate')) {
        Mark::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->update(['issue_date_certificate' => request()->get('issue_date_certificate')]);

        $allMarks = $allMarks->map(function ($mark) {
            $mark->issue_date_certificate = request()->get('issue_date_certificate');
            return $mark;
        });
    }

    $grandTotalObtained = 0;
    $grandTotalMax = 0;
    $yearWiseData = [];

    foreach ($allMarks as $mark) {
        $year = $mark->year;
        $subjects = $courseSubjects[$year] ?? [];

        if (empty($subjects)) continue;

        $marksData = is_array($mark->marks) ? $mark->marks : json_decode($mark->marks, true);

        $yearObtained = 0;
        $yearMax = 0;

        foreach ($subjects as $subject) {
            $subName  = $subject['subject_name'];
            $maxMarks = isset($subject['max_marks']) ? (int)$subject['max_marks'] : 100;
            $obtained = isset($marksData[$subName]) ? (int)$marksData[$subName] : 0;

            $yearObtained += $obtained;
            $yearMax += $maxMarks;
        }

        $grandTotalObtained += $yearObtained;
        $grandTotalMax += $yearMax;

        $yearWiseData[$year] = [
            'obtained'   => $yearObtained,
            'max'        => $yearMax,
            'percentage' => ($yearMax > 0) ? round(($yearObtained / $yearMax) * 100, 2) : 0
        ];
    }

    $marksObtainedInPercent = ($grandTotalMax > 0)
        ? round(($grandTotalObtained / $grandTotalMax) * 100, 2)
        : 0;

    $grade = $this->calculateGrade($marksObtainedInPercent);

    $issue_date_certificate = $allMarks->first()->issue_date_certificate;

    $certificateUrl = route('certificate.public.show', [
        'student_id' => $student->id,
        'course_id'  => $course->id
    ]);

    $result = (new Builder(
        writer: new PngWriter(),
        data: $certificateUrl,
        size: 120,
        margin: 10,
    ))->build();

    $qrCodeBase64 = base64_encode($result->getString());

    return view('subadmin.certificate.index', compact(
        'student',
        'course',
        'marksObtainedInPercent',
        'grandTotalObtained',
        'grandTotalMax',
        'grade',
        'yearWiseData',
        'qrCodeBase64',
        'issue_date_certificate',
        'mark'
    ));
}

    public function demoCerTest(){
        return view('subadmin.certificate.index_up');
        // return view('subadmin.certificate.index_marks');
    }


    public function giveAffiliation($id)
    {
        try {
            $subAdmin = ModelsSubAdmin::findOrFail($id);
            $subAdmin->affiliation = 1; 
            $subAdmin->save();
            return redirect()->back()->with('success', 'Affiliation granted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to grant affiliation: ' . $e->getMessage());
        }
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
        if ($percentage >= 70) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C+';
        if ($percentage >= 40) return 'C';
        if ($percentage >= 33) return 'D';
        return 'F';
    }
}
