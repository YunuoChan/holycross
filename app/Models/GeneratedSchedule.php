<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedSchedule extends Model
{
    use HasFactory;

    protected 	$table 			= 'generated_schedule';
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

    public function sectionSubject() {
        return $this->belongsTo(SectionSubject::class, 'section_subject_id');
    }

    public function schoolyear() {
        return $this->belongsTo(Schoolyear::class, 'schoolyear_id');
    }
}
