<?php

namespace App\Http\Controllers;

use App\Models\Schoolyear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class SchoolyearController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $schoolyears = Schoolyear::with('user')
                                ->where('status', 'ACT')
                                ->orderBy('sy_from', 'DESC')
                                ->get();
            return response()->json([
				'schoolyears' => $schoolyears
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
      
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexToEdit()
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

            $schoolyearEdit = Schoolyear::with('user')
                                ->where('id', $schoolYearId)
                                ->where('status', 'ACT')
                                ->first();

            return response()->json([
                'schoolyearEdit'    => $schoolyearEdit
			], 200);
        } catch (\Throwable $th) {
			return response()->json([
				'error'	=> $th
			], 500);
		}
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // SAVE SY RECORD
        try {

            $from   = $request->syfrom;
            $to     = $request->syto;
            $semester     = $request->semester;
            $userId = auth()->user()->id;
            if ($to  < $from ) {
                $from   = $request->syto;
                $to     = $request->syfrom;
            }
            
            $schoolYear = new Schoolyear();
            $schoolYear->sy_from    = $from;
            $schoolYear->sy_to      = $to;
            $schoolYear->semester   = $semester;
            $schoolYear->user_id    = $userId;
            $schoolYear->created_at = Carbon::now();
            $schoolYear->save();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // TRASH RECORD
        try {
            $id   = $request->id;
            $userId = auth()->user()->id;
        

            $schoolYear = Schoolyear::find($id);
            $schoolYear->updated_at = Carbon::now();
            $schoolYear->status = 'INA';
            $schoolYear->user_id = $userId;
            $schoolYear->update();


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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // *******************************************************        ADMIN SIDE        *******************************

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        return view('dashboard.adminschoolyear');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAdmin(Request $request)
    {
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setActiveSY(Request $request)
    {
        try {
            $id                     = $request->id;
            $userId                 = auth()->user()->id;
            
            Schoolyear::where('id', '<>', $id) 
                    ->where('is_active', 1)
                    ->update([
                        'updated_at'    => Carbon::now(),
                        'user_id'	    => $userId,
                        'is_active'     => 0
                    ]);
        
            $schoolyear                    = Schoolyear::find($id);
            $schoolyear->updated_at        = Carbon::now();
            $schoolyear->is_active         = 1;
            $schoolyear->user_id           = $userId;
            $schoolyear->update();

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAdmin(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAdmin($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAdmin($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAdmin(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAdmin(Request $request)
    {
        try {
            $id                     = $request->id;
            $userId                 = auth()->user()->id;
                    
            $schoolyear                    = Schoolyear::find($id);
            $schoolyear->updated_at        = Carbon::now();
            $schoolyear->status            = 'INA';
            $schoolyear->user_id           = $userId;
            $schoolyear->update();

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
