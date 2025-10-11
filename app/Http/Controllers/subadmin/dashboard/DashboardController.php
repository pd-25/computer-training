<?php

namespace App\Http\Controllers\subadmin\dashboard;

use App\core\bookingregister\BookingRegisterInterface;
use App\core\member\MemberInterface;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Course;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    // Dashboard======================================================================================================>
    public function dashboard(Request $request)
    {
        return view('subadmin.dashboard.dashboard');
    }

    public function studentsView(){
        
        return view('subadmin.student.index');
    }

}
