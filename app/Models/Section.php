<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected 	$table 			= 'section';
	protected 	$primaryKey 	= 'id';
	public 		$timestamps 	= false;

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:M d, Y'
    ];
     
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sectionSubjects() {
        return $this->hasMany(SectionSubject::class);
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function schoolyear() {
        return $this->belongsTo(Schoolyear::class, 'schoolyear_id');
    }
}
