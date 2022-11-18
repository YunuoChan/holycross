<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected 	$table 			= 'course';
	protected 	$primaryKey 	= 'id';
	public 		$timestamps 	= false;
    
    protected $fillable = [
        'course_code'
    ];

    protected $fillable = [
        'course_code'
    ];


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

    public function sections() {
        return $this->hasMany(Section::class);
    }

    public function subjects() {
        return $this->hasMany(Subject::class);
    }
}
