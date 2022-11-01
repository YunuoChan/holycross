<?php

namespace App\Http\Controllers;

use App\Models\Schoolyear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                                ->orderBy('created_at')
                                ->get();

            return response()->json([
				'schoolyears' => $schoolyears,
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

            if ($to  < $from ) {
                $from   = $request->syto;
                $to     = $request->syfrom;
            }
            
            $schoolYear = new Schoolyear();
            $schoolYear->sy_from = $from;
            $schoolYear->sy_to = $to;
            $schoolYear->user_id = auth()->user()->user_id;
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
    public function update(Request $request, $id)
    {
        //
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
}
