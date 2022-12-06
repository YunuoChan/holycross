<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Section;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Subject;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(isset($_COOKIE['__schoolYear_selected'])) {
            Log::debug($_COOKIE['__schoolYear_selected']);
            $_COOKIE['__schoolYear_selected'];

            return view('dashboard.dashboardstats');
        } else {
            return view('home');
        }
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getStatistics(Request $request)
    {
        // COUNT
        try {

            $yrlvl = $request->yearlvl;
            $course = $request->course;
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            // COURSE
            $courseCount =  Course::where('status', 'ACT')
                                    ->when(is_numeric($course), function ($query) use ($course) {
                                        return $query->where('id', $course);
                                    })
                                    ->count();

            // COURSE
            $sectionCount =  Section::where('status', 'ACT')
                                    ->when(is_numeric($yrlvl), function ($query) use ($yrlvl) {
                                        return $query->where('year_level', $yrlvl);
                                    })
                                    ->when(is_numeric($course), function ($query) use ($course) {
                                        return $query->where('course_id', $course);
                                    })
                                    ->where('schoolyear_id', $schoolYearId)
                                    ->count();
            // COURSE
            $professorCount =  Professor::where('status', 'ACT')
                                    ->when(is_numeric($course), function ($query) use ($course) {
                                        return $query->where('course_id', $course);
                                    })
                                    ->count();
            // Student
            $studentCount =  Student::where('status', 'ACT')
                                    ->when(is_numeric($yrlvl), function ($query) use ($yrlvl) {
                                        return $query->where('year_level', $yrlvl);
                                    })
                                    ->when(is_numeric($course), function ($query) use ($course) {
                                        return $query->where('course_id', $course);
                                    })
                                    ->where('schoolyear_id', $schoolYearId)
                                    ->count();
            // Subject
            $subjectCount =  Subject::where('status', 'ACT')
                                    ->when(is_numeric($yrlvl), function ($query) use ($yrlvl) {
                                        return $query->where('year_level', $yrlvl);
                                    })
                                    ->when(is_numeric($course), function ($query) use ($course) {
                                        return $query->where('course_id', $course);
                                    })
                                    ->where('schoolyear_id', $schoolYearId)
                                    ->count();
            

            return response()->json([
                'courseCount' => $courseCount,
                'sectionCount' => $sectionCount,
                'professorCount' => $professorCount,
                'studentCount' => $studentCount,
                'subjectCount' => $subjectCount
            ], 200);

        } catch (\Throwable $th) {
            Log::debug('Course.store');
            Log::debug($th);
            return response()->json([
                'error'	=> $th
            ], 500);
        }
       
    }
}
