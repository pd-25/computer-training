<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function index()
    {
        $categories = Category::whereNotNull('slug')->get();
        $courses = Course::whereNotNull('slug')->get();
        return view('frontend.index', compact('categories', 'courses'));
    }

    public function allCategoriesView(){
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
}
