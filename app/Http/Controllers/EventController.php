<?php


namespace App\Http\Controllers;

use App\Models\Events;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
   
    public function index()
    {
        $data = Events::all();

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Event data retrieved successfully'
        ], 200);
    }

    
    public function store(Request $request)
    { 
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

    
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $validator->errors(),
            ], 422); 
        }

         

        $validated = $validator->validated();

        $validated['user_id'] = auth()->user()->id;
 
        $event = Events::create($validated);

        return response()->json([
            'success' => true,
            'data' => $event,
            'message' => 'Event created successfully'
        ], 201); 
    }

  
    public function show($id)
    {
        $event = Events::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $event,
            'message' => 'Event details retrieved successfully'
        ], 200);
    }

     
    public function update(Request $request, $id)
    {
        $event = Events::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $validator->errors(),
            ], 422);
        }

        
        $validated = $validator->validated();

       
        $event->update($validated);

        return response()->json([
            'success' => true,
            'data' => $event,
            'message' => 'Event updated successfully'
        ], 200);
    }

    
    public function destroy($id)
    {
        $event = Events::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ], 200);
    }
}
