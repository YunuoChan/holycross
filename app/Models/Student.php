<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected 	$table 			= 'student';
	protected 	$primaryKey 	= 'id';
	public 		$timestamps 	= false;

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:M d, Y',
        'student_id_no' => 'string'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function section() {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
