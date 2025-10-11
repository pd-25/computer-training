<?php

namespace App\Http\Controllers\admin\dashboard;


use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;
use App\Models\SubAdmin as ModelsSubAdmin;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    // Dashboard======================================================================================================>
    public function dashboard(Request $request)
    {
        return view('admin.dashboard.dashboard');
    }


    // Category======================================================================================================>
    public function categoryView()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
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
    public function courseView()
    {
        $categories = Category::all();
        $courses = Course::with('category')->orderBy('id', 'desc')->paginate(10);
        return view('admin.course.index', compact('categories', 'courses'));
    }


    public function courseAdd(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'course_name' => 'required|string|unique:courses,course_name',
                'description' => 'nullable|string',
                'duration' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3048',
            ]);

            $course = new Course();
            $course->category_id = $request->category_id;
            $course->course_name = $request->course_name;
            $course->slug = Str::slug($request->course_name, '-');
            $course->description = $request->description;
            $course->duration = $request->duration;

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('courses', 'public');
                $course->image = $path;
            }

            $course->save();

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
                'description' => 'nullable|string',
                'duration' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3048',
            ]);

            $course = Course::findOrFail($id);
            $course->category_id = $request->category_id;
            $course->course_name = $request->course_name;
            $course->slug = Str::slug($request->course_name, '-');
            $course->description = $request->description;
            $course->duration = $request->duration;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($course->image && Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }

                $path = $request->file('image')->store('courses', 'public');
                $course->image = $path;
            }

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
    public function subadminView()
    {
        $subAdmins = ModelsSubAdmin::all();
        return view('admin.subadmin.index', compact('subAdmins'));
    }

    public function addSubAdmin(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return redirect()->back()->with('success', 'Sub Admin added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add Sub Admin: ' . $e->getMessage());
        }
    }

    public function editSubAdmin(Request $request, $id)
    {
        $subAdmin = ModelsSubAdmin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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
            $subAdmin->email = $request->email;

            if (!empty($request->password)) {
                $subAdmin->password = bcrypt($request->password);
            }

            $subAdmin->save();

            return redirect()->back()->with('success', 'Sub Admin updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Sub Admin: ' . $e->getMessage());
        }
    }

    public function deleteSubAdmin($id)
    {
        try {
            $subAdmin = ModelsSubAdmin::findOrFail($id);
            $subAdmin->delete();

            return redirect()->back()->with('success', 'Sub Admin deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Sub Admin: ' . $e->getMessage());
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
}
