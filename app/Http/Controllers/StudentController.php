<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.student');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // SAVE SECTION
         try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            $name                   = $request->name;
            $studentId              = $request->studentId;
            $course                 = $request->course;
            $section                = $request->section;
            $yearlevel              = $request->yearlevel;
            $fromAdmin              = $request->fromAdmin;
            $userId                 = auth()->user()->id;

            
            $student = new Student();
            $student->name              = $name;
            $student->student_id_no     = $studentId;
            $student->year_level        = $yearlevel;
            $student->section_id        = $section;
            $student->course_id         = $course;
            $student->user_id           = $userId;
            $student->created_at        = Carbon::now();
            if ($fromAdmin == 0) {
                $student->status        = 'PEN';
            }
            $student->save();

            return response()->json([
				'status' => 0,
			], 200);

        } catch (\Throwable $th) {
            Log::debug('Student.store');
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        try {
            $students = Student::with(['course' => function($course) {
                                $course->where('status', 'ACT');
                            }])
                            ->with(['section' => function($course) {
                                $course->where('status', 'ACT');
                            }])
                            ->whereHas('course', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->whereHas('section', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->orderBy('status', 'ASC')
                            ->orderBy('id', 'DESC')
                            ->get();

            return response()->json([
				'students' => $students
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Student $student)
    {
        try {
            $id   = $request->id;
            $userId = auth()->user()->id;
        
            $student = Student::find($id);
            $student->updated_at = Carbon::now();
            $student->status = 'INA';
            $student->user_id = $userId;
            $student->update();

            return response()->json([
                'status' => 0,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error'	=> $th
            ], 500);
        }
    }



     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function getSchedule(Request $request)
    {
        try {

            $student = $request->studentId;
            $students = Student::with(['course' => function($course) {
                                $course->where('status', 'ACT');
                            }])
                            ->with(['section' => function($course) {
                                $course->where('status', 'ACT')
                                    ->with(['sectionSubjects' => function($course) {
                                        $course->where('status', 'ACT')
                                            ->with(['generatedSchedules' => function($genSched) {
                                                $genSched->where('status', 'ACT')
                                                    ->orderBy('day', 'ASC');
                                            }])
                                            ->with(['subject' => function($subject) {
                                                $subject->where('status', 'ACT');
                                            }]);
                                    }]);
                            }])
                            ->whereHas('course', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->whereHas('section', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->where('student_id_no', $student)
                            ->orderBy('status', 'ASC')
                            ->orderBy('id', 'DESC')
                            ->first();

            return response()->json([
				'students' => $students
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

}
