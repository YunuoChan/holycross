<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Imports\StudentImport;
use App\Models\Section;
use Session;

class StudentController extends Controller
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

            $message = Session::get('csv_message_student');
            $status = Session::get('csv_status_student');
            $notInserted = Session::get('csv_notinserted_student');
            return view('dashboard.student', compact('message', 'status', 'notInserted'));
        } else {
            return view('home');
        }
    }


    public function validateHeaderRow($headerRow)
    {
        $validate = false;

        if( $headerRow[0] == 'user_id'
            && $headerRow[1] == 'customer_name' 
            && $headerRow[2] == 'date' )

            {
                $validate = true;
            } 

        return $validate;

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

            if (!$request->file) {
                Log::debug('Student.create');
                $message = 'Invalid CSV File';
                $status = 'error';
                return redirect()->route('student')->with(['csv_message_student' => $message, 'csv_status_student' => $status, 'csv_notinserted_student' => 0]);
            }

            
            // CONVERT CSV TO ARRAY
            $studentRecords = \Excel::toArray(new StudentImport, $request->file);
        
            $alreadyExist = 0;
            $isInvalid = 0;
            $notInsertedCount = 0;
            foreach($studentRecords[0] as $index => $record) {
                if (count($record) == 3) {
                    if ($index > 0) {
                        $isStudentExist = Student::where('student_id_no', $record[0])
                                            ->where('schoolyear_id', $schoolYearId)
                                            ->where('status', 'ACT')
                                            ->count();

                        if ($isStudentExist) {
                            $alreadyExist++;
                        }

                        $section = Section::where('section_code', $record[2])
                                        ->where('schoolyear_id', $schoolYearId)
                                        ->where('status', 'ACT')->first();
                        
                        $sectionId = null;
                        $courseId = null;
                        if ($section) {
                            $sectionId = $section->id;
                            $courseId = $section->course_id;
                        }

                        $userId                 = auth()->user()->id;


                        if ($isStudentExist < 1 && $section) {
                            $student = new Student();
                            $student->name              = $record[1];
                            $student->student_id_no     = $record[0];
                            $student->year_level        = $section->year_level;
                            $student->section_id        = $sectionId;
                            $student->course_id         = $courseId;
                            $student->schoolyear_id     = $schoolYearId;
                            $student->user_id           = $userId;
                            $student->created_at        = Carbon::now();
                            $student->save();
                        } else {
                            $notInsertedCount++;
                        }
                    } else {
                        if ($record[0] != 'studentId' || $record[1] != 'name' || $record[2] != 'sectionCode') {
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
                return redirect()->route('student')->with(['csv_message_student' => $message, 'csv_status_student' => $status, 'csv_notinserted_student' => 0]);
            } else {
                $message = 'CSV Imported Successfully!';
                $status = 'success';
                return redirect()->route('student')->with(['csv_message_student' => $message, 'csv_status_student' => $status, 'csv_notinserted_student' => $notInsertedCount]);
            }
        } catch (\Throwable $th) {
            Log::debug('Student.store');
            Log::debug($th);
            return redirect()->route('student')->with('fail', 'CSV is Invalid!');
		}
    }


    public function getSampleCSV() 
    {
         return response()->download(public_path('download/SampleCSV.csv'));
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

            $name                   = $request->name;
            $studentId              = $request->studentId;
            $course                 = $request->course;
            $section                = $request->section;
            $yearlevel              = $request->yearlevel;
            $fromAdmin              = $request->fromAdmin;
            $userId                 = auth()->user()->id;

            $isExist =  Student::where('student_id_no',  $studentId)
                                ->where('schoolyear_id', $schoolYearId)
                                ->where('status', 'ACT')
                                ->count();

            if ($isExist > 0) {
                return response()->json([
                    'status' => 66,
                    'message' => 'Student ID number already exist in the record'
                ], 200);
            }

            $student = new Student();
            $student->name              = $name;
            $student->student_id_no     = $studentId;
            $student->year_level        = $yearlevel;
            $student->section_id        = $section;
            $student->course_id         = $course;
            $student->schoolyear_id     = $schoolYearId;
            $student->user_id           = $userId;
            $student->created_at        = Carbon::now();
            if ($fromAdmin == 0) {
                $student->status        = 'PEN';
            }
            $student->save();

            return response()->json([
				'status' => 0,
			], 200);

        } catch (\Throwable $th) {
            Log::debug('Student.store');
            Log::debug($th);
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
    public function show(Request $request, Student $student)
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

            $students = Student::with(['course' => function($course) {
                                $course->where('status', 'ACT');
                            }])
                            ->with(['section' => function($section) use ($schoolYearId) {
                                $section->where('status', 'ACT')
                                ->where('schoolyear_id', $schoolYearId);
                            }])
                            ->whereHas('course', function($course) {
                                $course->where('status', 'ACT');
                            })
                            ->whereHas('section', function($section) use ($yearLevel){
                                $section->where('status', 'ACT')
                                ->when(is_numeric($yearLevel), function ($query) use ($yearLevel) {
                                    return $query->where('year_level', $yearLevel);
                                });
                            })
                            ->when(is_numeric($courseFilter), function ($query) use ($courseFilter) {
                                return $query->where('course_id', $courseFilter);
                            })
                            ->when($keyword, function ($query) use ($keyword) {
                                return $query->whereRaw('CONCAT(student_id_no, name) like "%'. $keyword .'%"');
                            })
                            ->where('status', 'ACT')
                            ->where('schoolyear_id', $schoolYearId)
                            ->orderBy('status', 'ASC')
                            ->orderBy('id', 'DESC')
                            ->get();

            return response()->json([
				'students' => $students
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Student $student)
    {
        try {
            $id = $request->id;
            $student = Student::with('course')
                            ->with('section')
                            ->where('id', $id)
                            ->first();

            return response()->json([
				'student' => $student
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
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

            $id                     = $request->id;
            $name                   = $request->name;
            $studentId              = $request->studentId;
            $course                 = $request->course;
            $section                = $request->section;
            $yearlevel              = $request->yearlevel;
            $fromAdmin              = $request->fromAdmin;
            $userId                 = auth()->user()->id;

            $isExist =  Student::where('student_id_no',  $studentId)
                            ->where('id', '<>', $id)
                            ->where('status', 'ACT')
                            ->count();

            if ($isExist > 0) {
                return response()->json([
                    'status' => 66,
                    'message' => 'Student ID number already exist in the record'
                ], 200);
            }

            
            $student = Student::find($id);
            $student->name              = $name;
            $student->student_id_no     = $studentId;
            $student->year_level        = $yearlevel;
            $student->section_id        = $section;
            $student->course_id         = $course;
            $student->user_id           = $userId;
            $student->updated_at        = Carbon::now();
            $student->update();

            return response()->json([
				'status' => 0,
			], 200);

        } catch (\Throwable $th) {
            Log::debug('Student.store');
            Log::debug($th);
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Student $student)
    {
        try {
            $id   = $request->id;
            $userId = auth()->user()->id;
        
            $student = Student::find($id);
            $student->updated_at = Carbon::now();
            $student->status = 'INA';
            $student->user_id = $userId;
            $student->update();

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

            $student = $request->studentId;
            $students = Student::with(['course' => function($course) {
                                $course->where('status', 'ACT');
                            }])
                            ->with(['section' => function($course) {
                                $course->where('status', 'ACT')
                                    ->with(['sectionSubjects' => function($course) {
                                        $course->where('status', 'ACT')
                                            ->with(['generatedSchedules' => function($genSched) {
                                                $genSched->where('status', 'ACT')
                                                    ->orderBy('day', 'ASC')
                                                    ->with(['professorSubject' => function($subject) {
                                                        $subject->where('status', 'ACT')
                                                        ->with(['professor' => function($subject) {
                                                            $subject->where('status', 'ACT');
                                                        }]);
                                                    }]);
                                            }])
                                            ->with(['subject' => function($subject) {
                                                $subject->where('status', 'ACT');
                                            }]);
                                    }])
                                    ->whereHas('schoolyear', function($query) {
                                        $query->where('is_active', 1)
                                            ->where('status', 'ACT');
                                    })
                                    ->with('schoolyear');
                            }])
                            ->whereHas('schoolyear', function($query) {
                                $query->where('is_active', 1)
                                    ->where('status', 'ACT');
                            })
                            ->whereHas('course', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->whereHas('section', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->where('student_id_no', $student)
                            ->orderBy('status', 'ASC')
                            ->orderBy('id', 'DESC')
                            ->first();

            return response()->json([
				'students' => $students
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
    public function getScheduleApi($student)
    {
        try {

            $students = Student::with(['course' => function($course) {
                                $course->where('status', 'ACT');
                            }])
                            ->with(['section' => function($course) {
                                $course->where('status', 'ACT')
                                    ->with(['sectionSubjects' => function($course) {
                                        $course->where('status', 'ACT')
                                            ->with(['generatedSchedules' => function($genSched) {
                                                $genSched->where('status', 'ACT')
                                                    ->orderBy('day', 'ASC')
                                                    ->with(['professorSubject' => function($subject) {
                                                        $subject->where('status', 'ACT')
                                                        ->with(['professor' => function($subject) {
                                                            $subject->where('status', 'ACT');
                                                        }]);
                                                    }]);
                                            }])
                                            ->with(['subject' => function($subject) {
                                                $subject->where('status', 'ACT');
                                            }]);
                                    }])
                                    ->whereHas('schoolyear', function($query) {
                                        $query->where('is_active', 1)
                                            ->where('status', 'ACT');
                                    })
                                    ->with('schoolyear');
                            }])
                            ->whereHas('schoolyear', function($query) {
                                $query->where('is_active', 1)
                                    ->where('status', 'ACT');
                            })
                            ->whereHas('course', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->whereHas('section', function($query) {
                                $query->where('status', 'ACT');
                            })
                            ->where('student_id_no', $student)
                            ->orderBy('status', 'ASC')
                            ->orderBy('id', 'DESC')
                            ->first();

            return response()->json([
				'students' => $students
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
    }

}
