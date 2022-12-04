<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\ProfessorSubject;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Imports\ProfessorImport;
use Illuminate\Support\Facades\Log;
use App\Models\Course;

class ProfessorController extends Controller
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

            return view('dashboard.professor');
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

            $name                   = $request->name;
            $professorId            = $request->profId;
            $course                 = $request->course;
            $userId                 = auth()->user()->id;

            $isExist =  Professor::where('professor_id_no', $professorId)
                            ->where('status', 'ACT')
                            ->count();

            if ($isExist > 0) {
                return response()->json([
                    'status' => 66,
                    'message' => 'Professor ID number already exist in the record'
                ], 200);
            }

            
            $professor = new Professor();
            $professor->name              = $name;
            $professor->professor_id_no   = $professorId;
            $professor->course_id         = $course;
            $professor->user_id           = $userId;
            $professor->created_at        = Carbon::now();
            $professor->save();

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
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show(Professor $professor, Request $request)
    {
        try {
            $courseFilter = $request->courseFilter;
            $keyword = $request->keyword;

            $professors = Professor::with(['course' => function($course) {
                                $course->where('status', 'ACT');
                            }])
                            ->whereHas('course', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->when(is_numeric($courseFilter), function ($query) use ($courseFilter) {
                                return $query->where('course_id', $courseFilter);
                            })
                            ->when($keyword, function ($query) use ($keyword) {
                                return $query->whereRaw('CONCAT(professor_id_no, name) like "%'. $keyword .'%"');
                            })
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
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Professor $professor)
    {
        try {
            $id = $request->id;
            $professor = Professor::with('course')
                            ->where('id', $id)
                            ->first();

            return response()->json([
				'professor' => $professor
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
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professor $professor)
    {
         // SAVE SECTION
         try {
            $id                     = $request->id;
            $name                   = $request->name;
            $professorId            = $request->profId;
            $course                 = $request->course;
            $userId                 = auth()->user()->id;

            $isExist =  Professor::where('professor_id_no', $professorId)
                            ->where('id', '<>', $id)
                            ->where('status', 'ACT')
                            ->count();

            if ($isExist > 0) {
                return response()->json([
                    'status' => 66,
                    'message' => 'Professor ID number already exist in the record'
                ], 200);
            }

            
            $professor = Professor::find($id);
            $professor->name              = $name;
            $professor->professor_id_no   = $professorId;
            $professor->course_id         = $course;
            $professor->user_id           = $userId;
            $professor->updated_at        = Carbon::now();
            $professor->update();

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Professor $professor)
    {
        try {
            $id   = $request->id;
            $userId = auth()->user()->id;
        
            $professor = Professor::find($id);
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function getSchedule(Request $request)
    {
        try {
            $prof = $request->professorId;

            $professor = Professor::with(['course' => function($course) {
                                        $course->where('status', 'ACT');
                                    }])
                                    ->with(['professorSubjects' => function($professorSubject) {
                                        $professorSubject->whereHas('schoolyear', function($query) {
                                            $query->where('is_active', 1);
                                        })
                                    ->with(['generatedSched' => function($genSched) {
                                        $genSched->where('status', 'ACT')
                                        ->with(['sectionSubject' => function($sectSubj) {
                                            $sectSubj->where('status', 'ACT')
                                            ->with(['section' => function($section) {
                                                $section->where('status', 'ACT');
                                            }])
                                            ->with(['subject' => function($subject) {
                                                $subject->where('status', 'ACT');
                                            }]);
                                        }]);
                                    }])
                                    ->where('status', 'ACT');
                                }])
                                ->where('professor_id_no', $prof)
                                ->where('status', 'ACT')
                                ->get();




            return response()->json([
				'professor' => $professor
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    public function getSampleCSV() 
    {
         return response()->download(public_path('download/CSVTemplate-Professor.csv'));
    }

    public function importCSV(Request $request) {
        try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            if (!$request->file) {
                Log::debug('prof.importCSV');
                return redirect()->route('professor')->with('fail', 'No CSV File added');
            }

            
            // CONVERT CSV TO ARRAY
            $profRecords = \Excel::toArray(new ProfessorImport, $request->file);
        
            foreach($profRecords[0] as $index => $record) {
                if ($index > 0) {

                    $userId                 = auth()->user()->id;
                    $isProfExist =  Professor::where('professor_id_no', $record[0])
                                    ->where('status', 'ACT')
                                    ->count();

                    $course = Course::where('course_code', $record[2])
                                    ->where('status', 'ACT')
                                    ->first();
                    
                    $courseId = null;
                    if ($course) {
                        $courseId = $course->id;
                    }

                    // SAVE IF EXIST
                    if ($isProfExist < 1 && $course) {
                        $professor = new Professor();
                        $professor->name              = $record[1];
                        $professor->professor_id_no   = $record[0];
                        $professor->course_id         = $courseId;
                        $professor->user_id           = $userId;
                        $professor->created_at        = Carbon::now();
                        $professor->save();
                    }
                }
            }


            return redirect()->route('professor')->with('success', 'User Imported Successfully!');
        } catch (\Throwable $th) {
            Log::debug($th);
            return response()->json([
                'error'	=> $th
            ], 500);
        }
    }

}
