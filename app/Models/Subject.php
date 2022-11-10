<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected 	$table 			= 'subject';
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

    public function schoolyear() {
        return $this->belongsTo(Schoolyear::class);
    }

    public function sectionSubjects() {
        return $this->hasMany(SectionSubject::class);
    }
}

