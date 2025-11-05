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
