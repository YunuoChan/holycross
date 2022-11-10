<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.subject');
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
        // SAVE SUBJECT
        try {
            $schoolYearId = null;
            if(isset($_COOKIE['__schoolYear_selected'])) {
                $schoolYearId = $_COOKIE['__schoolYear_selected'];
            } else {
                return response()->json([
                    'error'	=> 'Invalid Schoolyear!'
                ], 500);
            }

            $subjectName            = $request->subject;
            $subjectCode            = $request->subjectCode;
            $subjectDescription     = $request->subjectDescription;
            $subjectTime            = $request->subjectTime;
            $subjectUnit            = $request->subjectUnit;
            $subjectYearlevel       = $request->subjectYearlevel;
            $userId                 = auth()->user()->id;

            
            $subject = new Subject();
            $subject->subject           = $subjectName;
            $subject->subject_code      = $subjectCode;
            $subject->description       = $subjectDescription;
            $subject->year_level        = $subjectYearlevel;
            $subject->unit              = $subjectUnit;
            $subject->time_to_consume   = $subjectTime;
            $subject->schoolyear_id     = $schoolYearId;
            $subject->user_id           = $userId;
            $subject->created_at        = Carbon::now();
            $subject->save();

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
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
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
            $subjects = Subject::with('user')
                                ->where('schoolyear_id', $schoolYearId)
                                ->orderBy('status', 'ASC')
                                ->orderBy('id', 'DESC')
                                ->get();

            return response()->json([
				'subjects' => $subjects,
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
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Subject $subject)
    {
        try {
            $id = $request->id;
            $subject = Subject::find($id);

            return response()->json([
				'subject' => $subject,
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
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $id                     = $request->id;
            $subjectName            = $request->subject;
            $subjectCode            = $request->subjectCode;
            $subjectYearlevel       = $request->subjectYearlevel;
            $subjectDescription     = $request->subjectDescription;
            $subjectUnit            = $request->subjectUnit;
            $subjectTime            = $request->subjectTime;
            $userId                 = auth()->user()->id;
        
            $subject                    = Subject::find($id);
            $subject->updated_at        = Carbon::now();
            $subject->subject           = $subjectName;
            $subject->subject_code      = $subjectCode;
            $subject->description       = $subjectDescription;
            $subject->year_level        = $subjectYearlevel;
            $subject->unit              = $subjectUnit;
            $subject->time_to_consume   = $subjectTime;
            $subject->user_id = $userId;
            $subject->update();

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
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Subject $subject)
    {
        try {
            $id   = $request->id;
            $userId = auth()->user()->id;
        

            $subject = Subject::find($id);
            $subject->updated_at = Carbon::now();
            $subject->status = 'INA';
            $subject->user_id = $userId;
            $subject->update();

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
