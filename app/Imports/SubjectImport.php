<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;

class SubjectImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subject([
           //
           'subject_code'  => $row['SubjectCode'],
           'subject'       => $row['SubjectName'],
           'course'        => $row['Course'],
           'year_level'    => $row['YearLevel'],
           'time_consume'  => $row['TimeConsumeInMinute'],
           'room'          => $row['RoomNo'],
           'unit'          => $row['Unit']
        ]);
    }

     /**
    * @return array
    */
    public function rules(): array
    {
        return [ // use indexes as variables
            '0' => 'required|string',
            '1' => 'required|integer',        
            '2' => 'required|string',
            '3' => 'required|integer',
            '4' => 'required|integer',
            '5' => 'string',
            '6' => 'integer'
        ];
    }
}
