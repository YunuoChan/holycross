<?php

namespace App\Http\Controllers;

use App\Models\GenerateSchedule;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SectionSubject;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class GenerateScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.generate-schedule');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GenerateSchedule  $generateSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            $id         = $request->courseId;
            $userId     = auth()->user()->id;


            $sections = Section::with('user')
                                ->with(['course' => function($course) use ($id) {
                                    $course->where('status', 'ACT');
                                }])
                                ->whereHas('course', function($query) use ($id) {
                                    $query->when(is_numeric($id), function ($filter) use ($id) {
                                        return $filter->where('id', $id);
                                    }); 
                                })
                                ->where('schoolyear_id', $schoolYearId)
                                ->where('status', 'ACT')
                                ->orderBy('status', 'ASC')
                                ->orderBy('id', 'DESC')
                                ->get();

            return response()->json([
				'sections' => $sections,
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
     * @param  \App\Models\GenerateSchedule  $generateSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(GenerateSchedule $generateSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GenerateSchedule  $generateSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GenerateSchedule $generateSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GenerateSchedule  $generateSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(GenerateSchedule $generateSchedule)
    {
        //
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GenerateSchedule  $generateSchedule
     * @return \Illuminate\Http\Response
     */
    public function generateSched(Request $request)
    {
        try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            Log::debug(auth()->user());

            $id         = $request->courseId;
            $yearLevel  = $request->yearLevel;
            $userId     = auth()->user()->id;

            
            // GET SECTION LIST
            $sections = Section::whereHas('course', function($query) use ($id) {
                                    $query->when(is_numeric($id), function ($filter) use ($id) {
                                        return $filter->where('id', $id);
                                    }); 
                                })
                                ->where('schoolyear_id', $schoolYearId)
                                ->where('status', 'ACT')
                                ->where('year_level', $yearLevel)
                                ->get();

            // GET SUBJECT LIST
            $subjects = Subject::whereHas('course', function($query) use ($id) {
                                    $query->when(is_numeric($id), function ($filter) use ($id) {
                                        return $filter->where('id', $id);
                                    }); 
                                }) 
                                ->where('schoolyear_id', $schoolYearId)
                                ->where('status', 'ACT')
                                ->where('year_level', $yearLevel)
                                ->get();
            
            foreach ($sections as $section) {
                foreach ($subjects as $subject) {
                    $subjectEdit = new SectionSubject();
                    $subjectEdit->subject_id        = $subject->id;
                    $subjectEdit->section_id        = $section->id;
                    $subjectEdit->user_id               = $userId;
                    $subjectEdit->created_at        = Carbon::now();
                    $subjectEdit->schoolyear_id     = $schoolYearId;
                    $subjectEdit->save();
                }
            }

            $sectionSubj = SectionSubject::where('status', 'ACT')->get();


            return response()->json([
				'sectionSubjs' => $sectionSubj,
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }
}
