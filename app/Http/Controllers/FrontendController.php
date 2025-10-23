<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\FranchiseRequest;
use Illuminate\Support\Facades\Validator;
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

        return view('frontend.verification');
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
}
