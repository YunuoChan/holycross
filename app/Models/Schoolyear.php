<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schoolyear extends Model
{
    use HasFactory;
    protected 	$table 			= 'schoolyears';
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

    public function subjects() {
        return $this->hasMany(Subject::class);
    }

    public function generatedSchedules() {
        return $this->hasMany(GeneratedSchedule::class);
    }
}
