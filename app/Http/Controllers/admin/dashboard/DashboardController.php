<?php

namespace App\Http\Controllers\admin\dashboard;


use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;
use App\Models\FranchiseRequest;
use App\Models\Student;
use App\Models\SubAdmin as ModelsSubAdmin;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                'description' => 'nullable|string',
                'duration' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3048',
                'subjects' => 'required|array|min:1',
                'subjects.*.subject_name' => 'required|string',
                'subjects.*.min_marks' => 'required|numeric|min:0',
                'subjects.*.max_marks' => 'required|numeric|min:0',
            ]);

            $course = new Course();
            $course->category_id = $request->category_id;
            $course->course_name = $request->course_name;
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
                'description' => 'nullable|string',
                'duration' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3048',
                'subjects' => 'required|array|min:1',
                'subjects.*.subject_name' => 'required|string',
                'subjects.*.min_marks' => 'required|numeric|min:0',
                'subjects.*.max_marks' => 'required|numeric|min:0',
            ]);

            $course = Course::findOrFail($id);
            $course->category_id = $request->category_id;
            $course->course_name = $request->course_name;
            $course->slug = Str::slug($request->course_name, '-');
            $course->description = $request->description;
            $course->duration = $request->duration;

            // Image handling
            if ($request->hasFile('image')) {
                if ($course->image && Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }
                $path = $request->file('image')->store('courses', 'public');
                $course->image = $path;
            }

            // Update subjects
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
}
