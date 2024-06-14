<?php




namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TrainingScheduleController extends Controller
{
    public function index()
    {
        return response()->json(TrainingSchedule::all(), 200);

    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|exists:courses,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $trainingSchedule = TrainingSchedule::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Training Scheduled successfully',
                'data' => $trainingSchedule
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $trainingSchedule = TrainingSchedule::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'This is Scheduled Training',
                'data' => $trainingSchedule
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Training Schedule not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|exists:courses,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $trainingSchedule = TrainingSchedule::findOrFail($id);
            $trainingSchedule->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Training Scheduled Updated Successfully',
                'data' => $trainingSchedule
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Training Schedule not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $trainingSchedule = TrainingSchedule::findOrFail($id);
            $trainingSchedule->delete();
            return response()->json([
                'success' => true,
                'message' => 'Scheduled Training deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Training Schedule not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
