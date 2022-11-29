<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.course');
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
        // SAVE COUORSE
        try {

            $name                   = $request->name;
            $courseCode             = $request->courseCode;
            $userId                 = auth()->user()->id;

            $isExist =  Course::where('course_code', $courseCode)
                            ->where('status', 'ACT')
                            ->count();

            if ($isExist > 0) {
                return response()->json([
                    'status' => 66,
                    'message' => 'Course Code already exist in the record'
                ], 200);
            }

            
            $professor = new Course();
            $professor->course_name       = $name;
            $professor->course_code       = $courseCode;
            $professor->created_at        = Carbon::now();
            $professor->save();

            return response()->json([
				'status' => 0,
			], 200);

        } catch (\Throwable $th) {
            Log::debug('Course.store');
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function showRecord(Request $request, Course $course)
    {
        try {

            $courses = Course::where('status', 'ACT')
                                ->orderBy('course_code', 'ASC')
                                ->get();

            return response()->json([
				'courses' => $courses
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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Course $course)
    {
        try {
          
            $courses = Course::where('status', 'ACT')
                                ->orderBy('course_code', 'ASC')
                                ->get();

            return response()->json([
				'courses' => $courses,
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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Course $course)
    {
        try {
            $id = $request->id;
            $course = Course::where('id', $id)
                            ->first();

            return response()->json([
				'course' => $course
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        // SAVE SECTION
        try {
            $id                     = $request->id;
            $name                   = $request->name;
            $courseCode             = $request->courseCode;

            $isExist =  Course::where('course_code', $courseCode)
                        ->where('status', 'ACT')
                        ->where('id', '<>', $id)
                        ->count();
            if ($isExist > 0) {
                return response()->json([
                    'status' => 66,
                    'message' => 'Course Code already exist in the record'
                ], 200);
            }
            

            
            $course = Course::find($id);
            $course->course_name       = $name;
            $course->course_code       = $courseCode;
            $course->updated_at        = Carbon::now();
            $course->update();

            return response()->json([
				'status' => 0,
			], 200);

        } catch (\Throwable $th) {
            Log::debug('Course.update');
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Course $course)
    {
        try {
            
            $id   = $request->id;
            $userId = auth()->user()->id;
        
            $professor = Course::find($id);
            $professor->updated_at = Carbon::now();
            $professor->status = 'INA';
            $professor->update();

            return response()->json([
                'status' => 0,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error'	=> $th
            ], 500);
        }
    }
}
