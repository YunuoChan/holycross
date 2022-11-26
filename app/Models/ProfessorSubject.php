<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorSubject extends Model
{
    use HasFactory;
    protected 	$table 			= 'professor_subject';
	protected 	$primaryKey 	= 'id';
	public 		$timestamps 	= false;

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:M d, Y',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function professor() {
        return $this->belongsTo(Professor::class, 'id', 'professor_id');
    }

    public function generatedSched() {
        return $this->hasOne(GeneratedSchedule::class, 'id', 'generated_sched_id');
    }

    public function schoolyear() {
        return $this->belongsTo(Schoolyear::class);
    }
}
