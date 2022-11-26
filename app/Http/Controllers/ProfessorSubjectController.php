<?php

namespace App\Http\Controllers;

use App\Models\GeneratedSchedule;
use App\Models\ProfessorSubject;
use App\Models\Professor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class ProfessorSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.professorsubject');
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

            $profId                 = $request->profId;
            $subjects               = $request->subjects;
            $userId                 = auth()->user()->id;

            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            foreach ($subjects as $subject) {
                $professor = new ProfessorSubject();
                $professor->professor_id        = $profId;
                $professor->generated_sched_id  = $subject;
                $professor->schoolyear_id       = $schoolYearId;
                $professor->user_id             = $userId;
                $professor->created_at          = Carbon::now();
                $professor->save();
            }
            

            return response()->json([
				'status' => 0,
			], 200);

        } catch (\Throwable $th) {
            Log::debug('Professor.store');
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfessorSubject  $professorSubject
     * @return \Illuminate\Http\Response
     */
    public function show(ProfessorSubject $professorSubject)
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

            $professors = Professor::with(['professorSubjects' => function($subj) use ($schoolYearId) {
                                        $subj->where('status', 'ACT')
                                        ->where('schoolyear_id', $schoolYearId)
                                        ->with(['generatedSched' => function($genSched) {
                                            $genSched->where('status', 'ACT')
                                            ->with(['sectionSubject' => function($sectSubj) {
                                                $sectSubj->where('status', 'ACT')
                                                    ->with(['subject' => function($subj) {
                                                        $subj->where('status', 'ACT');
                                                    }])
                                                    ->with(['section' => function($section) {
                                                        $section->where('status', 'ACT') 
                                                        ->with(['course' => function($course) {
                                                            $course->where('status', 'ACT');
                                                        }]);
                                                    }]);
                                            }]);
                                        }]);
                                    }])
                                ->where('status', 'ACT')
                                ->orderBy('status', 'ASC')
                                ->orderBy('id', 'DESC')
                                ->get();

            return response()->json([
				'professors' => $professors
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
     * @param  \App\Models\ProfessorSubject  $professorSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfessorSubject $professorSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfessorSubject  $professorSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfessorSubject $professorSubject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfessorSubject  $professorSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProfessorSubject $professorSubject)
    {
        try {
            $id   = $request->id;
            $userId = auth()->user()->id;
        
            $professor = ProfessorSubject::find($id);
            $professor->updated_at = Carbon::now();
            $professor->status = 'INA';
            $professor->user_id = $userId;
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

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function showSubjectList(Request $request, Professor $professor)
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
            $id = $request->profId;
            
            $professor = Professor::with('course')
                            ->with(['professorSubjects' => function($subj) use ($schoolYearId) {
                                $subj->where('status', 'ACT')
                                ->where('schoolyear_id', $schoolYearId)
                                ->with(['generatedSched' => function($genSched) {
                                    $genSched->where('status', 'ACT')
                                    ->with(['sectionSubject' => function($sectSubj) {
                                        $sectSubj->where('status', 'ACT')
                                            ->with(['subject' => function($subj) {
                                                $subj->where('status', 'ACT');
                                            }])
                                            ->with(['section' => function($section) {
                                                $section->where('status', 'ACT') 
                                                ->with(['course' => function($course) {
                                                    $course->where('status', 'ACT');
                                                }]);
                                            }]);
                                    }]);
                                }]);
                            }])
                            ->whereHas('course', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->where('id', $id)
                            ->first();
            $subjectLists = GeneratedSchedule::with(['sectionSubject' => function($course) {
                                $course->where('status', 'ACT')
                                    ->with(['subject' => function($course) {
                                        $course->where('status', 'ACT');
                                       
                                    }])
                                    ->with(['section' => function($course) {
                                        $course->where('status', 'ACT') 
                                        ->with(['course' => function($course) {
                                            $course->where('status', 'ACT');
                                        }]);
                                    }]);
                            }])
                            ->where('schoolyear_id', $schoolYearId)
                            ->where('status', 'ACT')
                            ->get();

            return response()->json([
				'professor'     => $professor,
                'subjectLists'  => $subjectLists
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }
}
