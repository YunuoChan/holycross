<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Imports\SubjectImport;
use Carbon\Carbon;
use Session;


class SubjectController extends Controller
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

            $message = Session::get('csv_message_subject');
            $status = Session::get('csv_status_subject');
            $notInserted = Session::get('csv_notinserted_subject');
            return view('dashboard.subject', compact('message', 'status', 'notInserted'));
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
            $subjectTime            = $request->subjectTime;
            $subjectUnit            = $request->subjectUnit;
            $subjectYearlevel       = $request->subjectYearlevel;
            $subjectRoomNo          = $request->subjectRoomNo;
            // $subjectAvailability    = $request->subjectAvailability;
            $course                 = $request->course;
            $userId                 = auth()->user()->id;

            
            $subject = new Subject();
            $subject->subject           = $subjectName;
            $subject->subject_code      = $subjectCode;
            $subject->year_level        = $subjectYearlevel;
            // $subject->availability_per_week = $subjectAvailability;
            $subject->unit              = $subjectUnit;
            $subject->time_to_consume   = $subjectTime;
            $subject->schoolyear_id     = $schoolYearId;
            $subject->course_id         = $course;
            $subject->room_no           = $subjectRoomNo;
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
    public function show(Request $request, Subject $subject)
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

            $courseFilter   = $request->courseFilter;
            $yearLevel      = $request->yearLevelFilter;
            $keyword        = $request->keyword;

            $subjects = Subject::with('user')
                                ->when(is_numeric($courseFilter), function ($query) use ($courseFilter) {
                                    return $query->where('course_id', $courseFilter);
                                })
                                ->when(is_numeric($yearLevel), function ($query) use ($yearLevel) {
                                    return $query->where('year_level', $yearLevel);
                                })
                                ->when($keyword, function ($query) use ($keyword) {
                                    return $query->whereRaw('CONCAT(subject, subject_code, room_no) like "%'. $keyword .'%"');
                                })
                                ->where('status', 'ACT')
                                ->with('course')
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

            $subject = Subject::with('user')
                            ->with('course')
                            ->where('id', $id)
                            ->first();

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
            $subjectUnit            = $request->subjectUnit;
            $subjectTime            = $request->subjectTime;
            $course                 = $request->course;
            $userId                 = auth()->user()->id;
            $subjectRoomNo          = $request->subjectRoomNo;
        
            $subject                    = Subject::find($id);
            $subject->updated_at        = Carbon::now();
            $subject->subject           = $subjectName;
            $subject->subject_code      = $subjectCode;
            $subject->year_level        = $subjectYearlevel;
            $subject->unit              = $subjectUnit;
            $subject->time_to_consume   = $subjectTime;
            $subject->course_id         = $course;
            $subject->room_no           = $subjectRoomNo;
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


    public function getSampleCSV() 
    {
         return response()->download(public_path('download/CSVTemplate-Subject.csv'));
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
                $message = 'Invalid CSV File';
                $status = 'error';
                return redirect()->route('subject')->with(['csv_message_subject' => $message, 'csv_status_subject' => $status, 'csv_notinserted_subject' => 0]);
            }

            
            // CONVERT CSV TO ARRAY
            $subjectRecords = \Excel::toArray(new SubjectImport, $request->file);
            Log::debug($subjectRecords );
        

            $isInvalid = 0;
            $notInsertedCount = 0;
            foreach($subjectRecords[0] as $index => $record) {
                if (count($record) == 7) {
                    if ($index > 0) {

                        $userId                 = auth()->user()->id;
                        $course = Course::where('course_code', $record[2])
                                        ->where('status', 'ACT')
                                        ->first();
    
                        $courseId = null;
                        if ($course) {
                            $courseId = $course->id;
                        }
                       
                        $timeConsume = (($record[4] / 15) * 0.25);
    
                        // SAVE IF EXIST
                        if ($course) {
                            $isSubjExist =  Subject::where('subject_code', $record[0])
                                                    ->where('year_level', $record[3])
                                                    ->where('status', 'ACT')
                                                    ->where('schoolyear_id', $schoolYearId)
                                                    ->where('course_id', $courseId)
                                                    ->where('schoolyear_id', $schoolYearId)
                                                    ->count();
                            if ($isSubjExist < 1) {
                                $subject = new Subject();
                                $subject->subject           = $record[1];
                                $subject->subject_code      = $record[0];
                                $subject->year_level        = $record[3];
                                $subject->unit              = $record[5];
                                $subject->time_to_consume   = $timeConsume;
                                $subject->schoolyear_id     = $schoolYearId;
                                $subject->course_id         = $courseId;
                                $subject->room_no           = $record[4];
                                $subject->user_id           = $userId;
                                $subject->created_at        = Carbon::now();
                                $subject->save();
                            } else {
                                $notInsertedCount++;
                            }
                        } else {
                            $notInsertedCount++;
                        }
                    } else {
                        if ($record[0] != 'SubjectCode' || $record[1] != 'SubjectName' || $record[2] != 'Course' || $record[3] != 'YearLevel' || $record[4] != 'TimeConsumeInMinute' || $record[5] != 'RoomNo' || $record[6] != 'Unit') {
                            $isInvalid++;
                            break;
                        }
                    }
                } else { 
                    $isInvalid++;
                    break;
                   
                }
            }

            if ($isInvalid > 0) {
                $message = 'Invalid CSV File';
                $status = 'error';
                return redirect()->route('subject')->with(['csv_message_subject' => $message, 'csv_status_subject' => $status, 'csv_notinserted_subject' => 0]);
            } else {
                $message = 'CSV Imported Successfully!';
                $status = 'success';
                return redirect()->route('subject')->with(['csv_message_subject' => $message, 'csv_status_subject' => $status, 'csv_notinserted_subject' => $notInsertedCount]);
            }
            
        } catch (\Throwable $th) {
            Log::debug($th);
            return response()->json([
                'error'	=> $th
            ], 500);
        }
    }
}
