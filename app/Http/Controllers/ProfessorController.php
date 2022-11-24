<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.professor');
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
    public function show(Professor $professor)
    {
        try {
            $professors = Professor::with(['course' => function($course) {
                                $course->where('status', 'ACT');
                            }])
                            ->whereHas('course', function($query) {
                                $query->where('status', 'ACT');
                            })
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
}
