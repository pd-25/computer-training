<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\FranchiseRequest;
use App\Models\Mark;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function index()
    {
        $categories = Category::whereNotNull('slug')->get();
        $courses = Course::whereNotNull('slug')->get();
        return view('frontend.index', compact('categories', 'courses'));
    }

    public function allCategoriesView()
    {
        $categories = Category::whereNotNull('slug')->get();
        return view('frontend.categories', compact('categories'));
    }

    public function categoryWiseCourseView($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $courses = Course::where('category_id', $category->id)->get();

        return view('frontend.courses', compact('category', 'courses'));
    }

    public function courseDetails($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        return view('frontend.course-details', compact('course'));
    }

    public function aboutUs()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function events()
    {
        return view('frontend.events');
    }

    public function eventDetails()
    {

        return view('frontend.single-event');
    }

    public function gallery()
    {

        return view('frontend.gallery');
    }

    public function mission()
    {

        return view('frontend.mission');
    }

    public function vision()
    {

        return view('frontend.vision');
    }

    public function paynow()
    {

        return view('frontend.paynow');
    }

    public function computerMarksheet()
    {

        return view('frontend.computer-marksheet');
    }

    public function typing()
    {

        return view('frontend.typing');
    }

    public function certificate()
    {

        return view('frontend.certificate');
    }

    public function franchiseMode()
    {
        return view('frontend.franchise-mode');
    }

    public function wallet()
    {
        return view('frontend.wallet');
    }

    public function verification()
    {
        $courses = Course::all();
        return view('frontend.verification', compact('courses'));
    }

    public function verifyYourCertificate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'enrollment_no' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = Student::where('email', $request->email)
            ->where('enrollment_no', $request->enrollment_no)
            ->first();

        if (!$student) {
            return back()->with('error', 'No student found with provided details.');
        }

        $assignedCourses = is_array($student->assigned_course_id)
            ? $student->assigned_course_id
            : json_decode($student->assigned_course_id, true);

        if (empty($assignedCourses) || !in_array($request->course_id, $assignedCourses)) {
            return back()->with('error', 'This course is not assigned to the student.');
        }

        $course = Course::find($request->course_id);

        if (!$course) {
            return back()->with('error', 'Course not found.');
        }

        // Redirect to the certificate generator
        return redirect()->route('frontend.generate.certificate', [
            'student_id' => $student->id,
            'course_id' => $course->id,
        ]);
    }

    public function showCertificateIfAllMarksSubmitted($student_id, $course_id)
    {
        $student = Student::findOrFail($student_id);
        $course = Course::findOrFail($course_id);

        // Get all subjects for this course
        $courseSubjects = json_decode($course->subjects, true);

        if (!$courseSubjects) {
            return redirect()->route('frontend.verification')
                ->with('error', 'No subjects found for this course.');
        }

        // Calculate how many years/durations should have marks
        $totalYearsExpected = count($courseSubjects);

        // Get ALL marks for this student and course
        $allMarks = Mark::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->get();

        // Check if all years have marks submitted
        if ($allMarks->count() < $totalYearsExpected) {
            $submittedYears = $allMarks->pluck('year')->toArray();
            $missingYears = array_diff(array_keys($courseSubjects), $submittedYears);

            return redirect()->route('frontend.verification')
                ->with('error', 'Marks not submitted for all years/durations. Missing: Year(s) ' . implode(', ', $missingYears));
        }

        if ($allMarks->isEmpty()) {
            return redirect()->route('frontend.verification')
                ->with('error', 'No marks found for this student in this course. Please contact your institute.');
        }

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
        $certificateUrl = route('frontend.generate.certificate', [
            'student_id' => $student->id,
            'course_id' => $course->id
        ]);

        try {
            $result = (new Builder(
                writer: new PngWriter(),
                data: $certificateUrl,
                size: 120,
                margin: 10,
            ))->build();

            $qrCodeBase64 = base64_encode($result->getString());
        } catch (\Exception $e) {
            $qrCodeBase64 = null;
        }

        return view('subadmin.certificate.index', compact(
            'student',
            'course',
            'marksObtainedInPercent',
            'grandTotalObtained',
            'grandTotalMax',
            'grade',
            'yearWiseData',
            'qrCodeBase64'
        ));
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

    public function studentZone()
    {
        return view('frontend.student-zone');
    }

    public function franchise()
    {
        return view('frontend.franchise');
    }

    public function franchiseSubmit(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'investment' => 'required|numeric|min:0',
            'experience' => 'nullable|string|max:1000',
            'message' => 'nullable|string|max:2000',
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors in the form.');
        }

        try {
            // Create franchise request
            $franchiseRequest = FranchiseRequest::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'city' => $request->city,
                'state' => $request->state,
                'investment' => $request->investment,
                'experience' => $request->experience,
                'message' => $request->message,
                'terms' => $request->has('terms'),
                'status' => 'pending'
            ]);

            // Send email notification (optional)
            // Uncomment below if you want to send emails
            /*
            Mail::send('emails.franchise-request', ['data' => $franchiseRequest], function($message) use ($franchiseRequest) {
                $message->to('franchise@edublink.com')
                    ->subject('New Franchise Application from ' . $franchiseRequest->name);
            });

            // Send confirmation email to applicant
            Mail::send('emails.franchise-confirmation', ['data' => $franchiseRequest], function($message) use ($franchiseRequest) {
                $message->to($franchiseRequest->email)
                    ->subject('Thank You for Your Franchise Application');
            });
            */

            return redirect()->back()
                ->with('success', 'Thank you for your interest! Your franchise application has been submitted successfully. Our team will contact you within 24-48 hours.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again later or contact us directly.');
        }
    }

    public function franchiseLoginView()
    {
        return view('frontend.franchise-login');
    }
}
