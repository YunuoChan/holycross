<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            //
            'student_id_no' => $row['studentId'],
            'name'          => $row['name'],
            'section_code'  => $row['sectionCode']
        ]);
    }

     /**
    * @return array
    */
    public function rules(): array
    {
        return [ // use indexes as variables
            '0' => 'required|string',
            '1' => 'required|integer',            //validate unsigned integer
            '2' => 'required|integer'
        ];
    }
}
