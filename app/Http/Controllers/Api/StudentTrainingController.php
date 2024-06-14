<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TrainingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentTrainingController extends Controller
{
    public function optIn(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'student_id' => 'required|exists:students,id',
                'training_schedule_id' => 'required|exists:training_schedules,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $student = Student::findOrFail($request->student_id);
            $trainingSchedule = TrainingSchedule::findOrFail($request->training_schedule_id);

            $student->trainingSchedules()->attach($trainingSchedule, ['in_date' => now()]);

            return response()->json(['message' => 'Student opted in successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function optOut(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'student_id' => 'required|exists:students,id',
                'training_schedule_id' => 'required|exists:training_schedules,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $student = Student::findOrFail($request->student_id);
            $trainingSchedule = TrainingSchedule::findOrFail($request->training_schedule_id);

            $student->trainingSchedules()->updateExistingPivot($trainingSchedule->id, ['out_date' => now()]);

            return response()->json(['message' => 'Student opted out successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
