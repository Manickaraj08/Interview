<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    public function trainingSchedules()
    {
        return $this->belongsToMany(TrainingSchedule::class, 'student_training')
                    ->withPivot('in_date', 'out_date')
                    ->withTimestamps();
    }
}
