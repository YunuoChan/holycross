<?php

namespace App\Http\Controllers;

use App\Models\SectionSubject;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class SectionSubjectController extends Controller
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

            return view('dashboard.section-subject');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SectionSubject  $sectionSubject
     * @return \Illuminate\Http\Response
     */
    public function show(SectionSubject $sectionSubject)
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

            $sections = Section::with('user')
                                ->with(['sectionSubjects' => function($sectSub)  {
                                    $sectSub ->where('status', 'ACT')
                                        ->with(['subject' => function($subject)  {
                                            $subject->where('status', 'ACT');
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
     * @param  \App\Models\SectionSubject  $sectionSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(SectionSubject $sectionSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SectionSubject  $sectionSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SectionSubject $sectionSubject)
    {
        Log::debug($request);
        try {
            $section    = $request->section;
            $subject    = $request->sectionSelected;
            $userId     = auth()->user()->id;

            SectionSubject::where('section_id', $section) 
                        ->whereNotIn('subject_id', $subject)
                        ->where('status', 'ACT')
                        ->update([
                            'status'        => 'INA',
                            'updated_at'    => Carbon::now()
                            // 'user_id'	    => $userId
                        ]);

            foreach($subject as $subj) {
                $subjSect = SectionSubject::where('section_id', $section) 
                            ->where('subject_id', $subj)
                            ->where('status', 'ACT')
                            ->count();

                if ($subjSect == 0) {
                    $subjectEdit = new SectionSubject();
                    $subjectEdit->subject_id        = $subj;
                    $subjectEdit->section_id        = $section;
                    // $subject->user_id           = $userId;
                    $subjectEdit->created_at        = Carbon::now();
                    $subjectEdit->save();
                }
            }


            return response()->json([
				'subject' => $subject,
			], 200);
        } catch (\Throwable $th) {
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SectionSubject  $sectionSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SectionSubject $sectionSubject)
    {
        Log::debug($request);

        try {
            $section    = $request->section;
            $subject    = $request->subject;
            $userId     = auth()->user()->id;

            SectionSubject::where('section_id', $section) 
                        ->where('subject_id', $subject)
                        ->where('status', 'ACT')
                        ->update([
                            'status'        => 'INA',
                            'updated_at'    => Carbon::now()
                            // 'user_id'	    => $userId
                        ]);

            return response()->json([
				'subject' => $subject,
			], 200);
        } catch (\Throwable $th) {
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    public function sectionData(Request $request) {
        try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            $id = $request->id;

            $yearLevel  = Section::where('id', $id)->pluck('year_level');
            $subjects   = Subject::where('schoolyear_id', $schoolYearId)
                                ->where('year_level', $yearLevel)
                                ->where('status', 'ACT')
                                ->get();
            $section = Section::with('user')
                                ->with(['sectionSubjects' => function($sectSub)  {
                                    $sectSub ->where('status', 'ACT')
                                        ->with(['subject' => function($subject)  {
                                            $subject->where('status', 'ACT');
                                        }]);
                                }])
                                ->where('id', $id)
                                ->get();

            

            return response()->json([
				'section' => $section,
                'subjects'=> $subjects
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }
}
