<?php

namespace App\Imports;

use App\Models\Professor;
use Maatwebsite\Excel\Concerns\ToModel;

class ProfessorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Professor([
            // FIELD SHOULD BE IN CSV
            'professor_id_no' => $row['ProfessorId'],
            'name'          => $row['Name'],
            'department'  => $row['Department']
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
            '2' => 'required|string'
        ];
    }
}
