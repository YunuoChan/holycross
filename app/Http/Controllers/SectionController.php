<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SectionController extends Controller
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

            return view('dashboard.section');
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

            $sectionName            = $request->sectionCode;
            $course                 = $request->course;
            $sectionYearlevel       = $request->sectionYearlevel;
            $userId                 = auth()->user()->id;

            
            $section = new Section();
            $section->section           = $sectionName;
            $section->section_code      = $sectionName;
            $section->year_level        = $sectionYearlevel;
            $section->schoolyear_id     = $schoolYearId;
            $section->course_id         =  $course;
            $section->user_id           = $userId;
            $section->created_at        = Carbon::now();
            $section->save();

            return response()->json([
				'status' => 0,
			], 200);

        } catch (\Throwable $th) {
            Log::debug('Section.store');
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section, Request $request)
    {
         //
         try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }
            $courseFilter   = $request->courseFilter;
            $yearLevel      = $request->yearLevelFilter;
            $keyword        = $request->keyword;


            $sections = Section::with('user')->with('course')
                                ->when(is_numeric($courseFilter), function ($query) use ($courseFilter) {
                                    return $query->where('course_id', $courseFilter);
                                })
                                ->when(is_numeric($yearLevel), function ($query) use ($yearLevel) {
                                    return $query->where('year_level', $yearLevel);
                                })
                                ->when($keyword, function ($query) use ($keyword) {
                                    return $query->whereRaw('CONCAT(section, section_code) like "%'. $keyword .'%"');
                                })
                                ->where('status', 'ACT')
                                ->where('schoolyear_id', $schoolYearId)
                                ->orderBy('status', 'ASC')
                                ->orderBy('id', 'DESC')
                                ->get();

            return response()->json([
				'sections' => $sections,
			], 200);
        } catch (\Throwable $th) {
            Log::debug('Section.show');
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

      /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function showSpecific(Request $request)
    {
         //
         try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }
            $course = $request->courseId;
            $yrLvl  = $request->yearLevel;

            $sections = Section::with('user')->with('course')
                                ->where('schoolyear_id', $schoolYearId)
                                ->where('course_id',  $course)
                                ->where('year_level', $yrLvl)
                                ->orderBy('status', 'ASC')
                                ->orderBy('section_code', 'ASC')
                                ->orderBy('id', 'DESC')
                                ->get();

            return response()->json([
				'sections' => $sections,
			], 200);
        } catch (\Throwable $th) {
            Log::debug('Section.show');
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Section $section)
    {
        try {
            $id = $request->id;
            $section = Section::with('course')
                            ->where('id', $id)
                            ->first();

            return response()->json([
				'section' => $section
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
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $id                     = $request->id;
            $course                 = $request->course;
            $sectionCode            = $request->sectionCode;
            $sectionYearlevel       = $request->sectionYearlevel;
            $userId = auth()->user()->id;
        
            $section                    = Section::find($id);
            $section->updated_at        = Carbon::now();
            $section->section           = $sectionCode;
            $section->section_code      = $sectionCode;
            $section->course_id         = $course;
            $section->year_level        = $sectionYearlevel;
            $section->user_id = $userId;
            $section->update();

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Section $section)
    {
        try {
            $id   = $request->id;
            $userId = auth()->user()->id;
        
            $section = Section::find($id);
            $section->updated_at = Carbon::now();
            $section->status = 'INA';
            $section->user_id = $userId;
            $section->update();

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
