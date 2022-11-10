<?php

namespace App\Http\Controllers;

use App\Models\SectionSubject;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.section-subject');
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
                                            $subject ->where('status', 'ACT');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SectionSubject  $sectionSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(SectionSubject $sectionSubject)
    {
        //
    }
}
