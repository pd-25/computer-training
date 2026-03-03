<?php

namespace App\Http\Controllers\subadmin\dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Mark;
use App\Models\Student;
use App\Models\TopupRequest;
use App\Models\Transaction;
use App\Models\Wallet;
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
        $totalStudents = Student::where('created_by', Auth::guard('subadmin')->id())->count();
        return view('subadmin.dashboard.dashboard', compact('totalStudents'));
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

    // public function studentAdd(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:students,email',
    //         'phone' => 'required|string|max:15',
    //         'father_name' => 'nullable|string|max:255',
    //         'dob' => 'nullable|date',
    //         'admission_date' => 'nullable|date',
    //         'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3048',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->with('error', $validator->errors()->first())->withInput();
    //     }

    //     try {

    //         DB::beginTransaction();

    //         $subadminId = Auth::guard('subadmin')->id();

    //         /** ------------------------------------------------------
    //          * 1. CHECK WALLET BALANCE (Need minimum ₹10)
    //          * ------------------------------------------------------ */
    //         $wallet = Wallet::where('subadmin_id', $subadminId)->first();

    //         // WALLET CHECK (Minimum ₹10 Required)
    //         if (!$wallet || $wallet->amount < 10) {
    //             return redirect()
    //                 ->route('subadmin.wallet')   // redirect here
    //                 ->with('error', 'Insufficient wallet balance! You need at least ₹10 to add a student.');
    //         }

    //         /** ------------------------------------------------------
    //          * 2. DEDUCT ₹10 FROM WALLET
    //          * ------------------------------------------------------ */
    //         $wallet->amount -= 10;
    //         $wallet->save();

    //         $availableBalance = $wallet->amount; // after deduction

    //         /** ------------------------------------------------------
    //          * 3. CREATE STUDENT (only after wallet deduction)
    //          * ------------------------------------------------------ */

    //         // Handle image upload
    //         $imagePath = null;
    //         if ($request->hasFile('image')) {
    //             $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
    //             $request->file('image')->move(public_path('uploads/students'), $imageName);
    //             $imagePath = 'uploads/students/' . $imageName;
    //         }

    //         $student = Student::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'phone' => $request->phone,
    //             'father_name' => $request->father_name,
    //             'dob' => $request->dob,
    //             'admission_date' => $request->admission_date,
    //             'org_name' => Auth::guard('subadmin')->user()->org_name,
    //             'image' => $imagePath,
    //             'created_by' => $subadminId,
    //         ]);

    //         // Enrollment number: NITE000 + student.id
    //         $prefix = "NITE000";
    //         $enrollmentNo = $prefix . $student->id;

    //         $student->update([
    //             'enrollment_no' => $enrollmentNo
    //         ]);

    //         /** ------------------------------------------------------
    //          * 4. ADD ENTRY INTO TRANSACTIONS TABLE
    //          * ------------------------------------------------------ */
    //         Transaction::create([
    //             'subadmin_id'   => $subadminId,
    //             'student_id'    => $student->id,
    //             'debit_balance' => 10,                 // deducted amount
    //             'avl_balance'   => $availableBalance,  // after deduction
    //         ]);

    //         DB::commit();

    //         return redirect()->back()->with('success', 'Student added successfully.');
    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return redirect()->back()->with('error', 'Failed to add student: ' . $e->getMessage());
    //     }
    // }

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

            DB::beginTransaction();

            $subadminId = Auth::guard('subadmin')->id();
            $student = Student::findOrFail($request->student_id);
            $courseIds = array_values($request->assigned_course_id);

            /** ------------------------------------------------------
             * 1. CALCULATE TOTAL COURSE PRICE
             * ------------------------------------------------------ */
            $courses = Course::whereIn('id', $courseIds)->get();
            $totalPrice = $courses->sum('price');

            /** ------------------------------------------------------
             * 2. CHECK WALLET BALANCE
             * ------------------------------------------------------ */
            $wallet = Wallet::where('subadmin_id', $subadminId)->first();

            if (!$wallet || $wallet->amount < $totalPrice) {
                DB::rollBack();
                return redirect()
                    ->route('subadmin.wallet')
                    ->with('error', "Insufficient wallet balance! You need at least ₹{$totalPrice} to assign these courses.");
            }

            /** ------------------------------------------------------
             * 3. DEDUCT TOTAL PRICE FROM WALLET
             * ------------------------------------------------------ */
            $wallet->amount -= $totalPrice;
            $wallet->save();

            $availableBalance = $wallet->amount; // after deduction

            /** ------------------------------------------------------
             * 4. ASSIGN COURSES TO STUDENT
             * ------------------------------------------------------ */
            $student->assigned_course_id = $courseIds;
            $student->save();

            /** ------------------------------------------------------
             * 5. ADD ENTRY INTO TRANSACTIONS TABLE
             * ------------------------------------------------------ */
            Transaction::create([
                'subadmin_id'   => $subadminId,
                'student_id'    => $student->id,
                'debit_balance' => $totalPrice,           // total deducted amount
                'avl_balance'   => $availableBalance,     // after deduction
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Courses assigned to student successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
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

    public function generateCertificate(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'issue_date_certificate' => 'required|date',
        ]);

        $student = Student::findOrFail($request->student_id);
        $course = Course::findOrFail($request->course_id);

        // Get all subjects for this course
        $courseSubjects = json_decode($course->subjects, true);

        if (!$courseSubjects) {
            return redirect()->back()->with('error', 'No subjects found for this course.');
        }

        // Get ALL marks for this student and course (all years)
        $allMarks = Mark::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->get();

        if ($allMarks->isEmpty()) {
            return redirect()->back()->with('error', 'No marks found for this student in this course.');
        }

        // Store issue_date_certificate
        Mark::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->update(['issue_date_certificate' => $request->issue_date_certificate]);

        // Calculate total marks across ALL years
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
                $subName = $subject['subject_name'];
                $maxMarks = isset($subject['max_marks']) ? (int)$subject['max_marks'] : 100;
                $obtained = isset($marksData[$subName]) ? (int)$marksData[$subName] : 0;

                $yearObtained += $obtained;
                $yearMax += $maxMarks;
            }

            $grandTotalObtained += $yearObtained;
            $grandTotalMax += $yearMax;

            // Store year-wise breakdown
            $yearWiseData[$year] = [
                'obtained' => $yearObtained,
                'max' => $yearMax,
                'percentage' => ($yearMax > 0) ? round(($yearObtained / $yearMax) * 100, 2) : 0
            ];
        }

        // Calculate overall percentage
        $marksObtainedInPercent = ($grandTotalMax > 0)
            ? round(($grandTotalObtained / $grandTotalMax) * 100, 2)
            : 0;

        // Calculate grade
        $grade = $this->calculateGrade($marksObtainedInPercent);

        // Generate QR Code for certificate verification
        $certificateUrl = route('certificate.public.show', [
            'student_id' => $student->id,
            'course_id' => $course->id
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
            'mark'
        ));
    }

    public function showPublicCertificate($student_id, $course_id)
    {
        $student = Student::findOrFail($student_id);
        $course = Course::findOrFail($course_id);

        // Get all subjects for this course
        $courseSubjects = json_decode($course->subjects, true);

        if (!$courseSubjects) {
            abort(404, 'No subjects found for this course.');
        }

        // Get ALL marks for this student and course (all years)
        $allMarks = Mark::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->get();

        if ($allMarks->isEmpty()) {
            abort(404, 'No marks found for this student in this course.');
        }

        $mark = $allMarks->first();

        // Calculate total marks across ALL years
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
                $subName = $subject['subject_name'];
                $maxMarks = isset($subject['max_marks']) ? (int)$subject['max_marks'] : 100;
                $obtained = isset($marksData[$subName]) ? (int)$marksData[$subName] : 0;

                $yearObtained += $obtained;
                $yearMax += $maxMarks;
            }

            $grandTotalObtained += $yearObtained;
            $grandTotalMax += $yearMax;

            // Store year-wise breakdown
            $yearWiseData[$year] = [
                'obtained' => $yearObtained,
                'max' => $yearMax,
                'percentage' => ($yearMax > 0) ? round(($yearObtained / $yearMax) * 100, 2) : 0
            ];
        }

        // Calculate overall percentage
        $marksObtainedInPercent = ($grandTotalMax > 0)
            ? round(($grandTotalObtained / $grandTotalMax) * 100, 2)
            : 0;

        // Calculate grade
        $grade = $this->calculateGrade($marksObtainedInPercent);

        // Don't generate QR code for public view (to avoid recursion)
        $qrCodeBase64 = null;

        return view('subadmin.certificate.index', compact(
            'student',
            'course',
            'marksObtainedInPercent',
            'grandTotalObtained',
            'grandTotalMax',
            'grade',
            'yearWiseData',
            'qrCodeBase64',
            'mark'
        ));
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
            'session_from' => 'required|date',
            'session_to' => 'required|date|after:session_from',
            'issue_date' => 'required|date',
        ]);

        $mark = Mark::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'course_id' => $validated['course_id'],
                'year' => $validated['year'],
                'session_from' => $validated['session_from'],
                'session_to' => $validated['session_to'],
                'issue_date' => $validated['issue_date'],
            ],
            [
                'marks' => $validated['marks'],
            ]
        );

        return redirect()->route('subadmin.marksheet.get', [
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'year' => $validated['year'],
            'issue_date' => $validated['issue_date'],
            'session_from' => $validated['session_from'],
            'session_to' => $validated['session_to'],
            
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

        // Get year from query parameter if not in URL
        if ($year === null && request()->has('year')) {
            $year = request()->get('year');
        }

        // Get subjects from course
        $courseSubjects = json_decode($course->subjects, true);

        if (!$courseSubjects) {
            return redirect()->back()->with('error', 'No subjects found for this course.');
        }

        // IF YEAR IS SPECIFIED - SHOW ONLY THAT YEAR
        if ($year !== null && $year != '') {
            $mark = Mark::where('student_id', $student_id)
                ->where('course_id', $course_id)
                ->where('year', $year)
                ->first();

            if (!$mark) {
                return redirect()->back()->with('error', 'No marks found for Year ' . $year);
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

            // Return SINGLE YEAR view
            return view('subadmin.certificate.marksheet', compact(
                'student',
                'course',
                'subjectDetails',
                'totalMarksObtained',
                'totalMaxMarks',
                'overallPercentage',
                'overallGrade',
                'year',
                'mark'
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

        // Return ALL YEARS view
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



    // Wallet
    public function myWallet(Request $request)
    {
        $myWallet = Wallet::where('subadmin_id', Auth::guard('subadmin')->id())->first();
        $transactions = Transaction::where('subadmin_id', Auth::guard('subadmin')->id())->orderBy('created_at', 'desc')->get();
        $totalTransactionAmount = $transactions->sum('debit_balance');

        return view('subadmin.wallet.index', compact('myWallet', 'transactions', 'totalTransactionAmount'));
    }

    public function topupRequest(Request $request)
    {
        try {
            // Validate
            $request->validate([
                'subadmin_id' => 'required|exists:sub_admins,id',
                'amount' => 'required|numeric|min:100',
                'payment_reciept' => 'nullable|mimes:jpg,jpeg,png,pdf|max:4048'
            ]);

            // Upload receipt file
            $receiptPath = null;
            if ($request->hasFile('payment_reciept')) {
                $receiptPath = $request->file('payment_reciept')->store('topup_receipts', 'public');
            }

            // Save Topup Request
            TopupRequest::create([
                'subadmin_id' => $request->subadmin_id,
                'amount' => $request->amount,
                'payment_reciept' => $receiptPath,
                'status' => 'pending'
            ]);

            return redirect()->back()->with('success', 'Top-up request submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function showAffiliation()
    {
        $subadmin = Auth::guard('subadmin')->user();
        
        if ($subadmin->affiliation != 1) {
            return redirect()->back()->with('error', 'Affiliation certificate is not available yet.');
        }

        return view('subadmin.certificate.affiliation', compact('subadmin'));
    }
}
