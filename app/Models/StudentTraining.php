<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTraining extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'training_schedule_id'];
}
