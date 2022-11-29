<?php

namespace App\Http\Controllers;

use App\Models\GeneratedSchedule;
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
        if (isset($_COOKIE['__schoolYear_selected'])) {
            Log::debug($_COOKIE['__schoolYear_selected']);
            $_COOKIE['__schoolYear_selected'];

            return view('dashboard.generate-schedule');
        } else {
            return view('home');
        }
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
        try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            $data         = $request->days;
            $course         = $request->course;
            $yearLevel         = $request->yearLevel;
            $userId     = auth()->user()->id;

            // GET SECTION LIST
            $sections = Section::whereHas('course', function($query) use ($course) {
                            $query->when(is_numeric($course), function ($filter) use ($course) {
                                return $filter->where('id', $course);
                            }); 
                        })
                        ->where('schoolyear_id', $schoolYearId)
                        ->where('status', 'ACT')
                        ->where('year_level', $yearLevel)
                        ->get();

            // GET SUBJECT LIST
            $subjects = Subject::whereHas('course', function($query) use ($course) {
                            $query->when(is_numeric($course), function ($filter) use ($course) {
                                return $filter->where('id', $course);
                            }); 
                        }) 
                        ->where('schoolyear_id', $schoolYearId)
                        ->where('status', 'ACT')
                        ->where('year_level', $yearLevel)
                        ->get();


            foreach ($sections as $section) {
                foreach ($subjects as $subject) {
                    $secSubId = SectionSubject::where('subject_id', $subject->id) 
                                        ->where('section_id', $section->id)
                                        ->where('schoolyear_id', $schoolYearId)
                                        ->where('status', 'INA')
                                        ->pluck('id');
                    
                    // INACTIVE THE EXISTING RECORD
                    GeneratedSchedule::whereIn('section_subject_id', array($secSubId)) 
                            ->where('status', 'ACT')
                            ->update([
                                'updated_at'    => Carbon::now(),
                                'user_id'	    => $userId,
                                'status'        => 'INA'
                            ]);
                    }
            }

            foreach($data['days'] as $day) {
                if (array_key_exists('subjects', $day)) {
                    foreach($day['subjects'] as $subj) {
                        $genSched = new GeneratedSchedule();
                        $genSched->section_subject_id = $subj['id'];
                        $genSched->day = $day['day'];
                        $genSched->schoolyear_id = $schoolYearId;
                        $genSched->user_id = $userId;
                        $genSched->from = $subj['from'];
                        $genSched->to = $subj['to'];
                        $genSched->created_at = Carbon::now();
                        $genSched->save();
                    }
                }
            }

            $generatedScheds = GeneratedSchedule::where('status', 'ACT')
                            ->where('schoolyear_id', $schoolYearId)
                            ->get();


            return response()->json([
				'generatedScheds' => $generatedScheds,
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
     * @param  \App\Models\GeneratedSchedule  $generatedSchedule
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
                                ->with(['sectionSubjects' => function($course) use ($schoolYearId) {
                                    $course->where('status', 'ACT')
                                        ->with(['generatedSchedules' => function($course) use ($schoolYearId) {
                                            $course->where('status', 'ACT')
                                                ->where('schoolyear_id', $schoolYearId);
                                        }])
                                        ->with(['subject' => function($course) use ($schoolYearId) {
                                            $course->where('status', 'ACT')
                                                ->where('schoolyear_id', $schoolYearId);
                                        }]);
                                }])
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
     * @param  \App\Models\GeneratedSchedule  $generatedSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(GeneratedSchedule $generatedSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneratedSchedule  $generatedSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneratedSchedule $generatedSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeneratedSchedule  $generatedSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeneratedSchedule $generatedSchedule)
    {
        //
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneratedSchedule  $generatedSchedule
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
                     
                    SectionSubject::where('subject_id', $subject->id) 
                        ->where('section_id', $section->id)
                        ->where('schoolyear_id', $schoolYearId)
                        ->where('status', 'ACT')
                        ->update([
                            'updated_at'    => Carbon::now(),
                            'user_id'	    => $userId,
                            'status'        => 'INA'
                        ]);
                    $subjectEdit = new SectionSubject();
                    $subjectEdit->subject_id        = $subject->id;
                    $subjectEdit->section_id        = $section->id;
                    $subjectEdit->user_id           = $userId;
                    $subjectEdit->created_at        = Carbon::now();
                    $subjectEdit->schoolyear_id     = $schoolYearId;
                    $subjectEdit->save();
                }
            }

            $sectionSubjNew = SectionSubject::where('status', 'ACT')
                                    ->where('schoolyear_id', $schoolYearId)
                                    ->get();


            return response()->json([
				'sectionSubjs' => $sectionSubjNew,
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
     * @param  \App\Models\GeneratedSchedule  $generatedSchedule
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        try {
          
            $sectionSubj = SectionSubject::where('status', 'ACT')->with('subject')->get();


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
