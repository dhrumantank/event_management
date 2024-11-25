<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Attendees;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendeeController extends Controller
{
     
    public function index($id)
    {

        
        $event = Events::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }


        

        $attendeesData = $event->attendees;

        return response()->json([
            'success' => true,
            'data' => $attendeesData,
            'message' => 'Attendees retrieved successfully'
        ], 200);
    }
 
    public function store(Request $request, $id)
    {

        $event = Events::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
 
        $input = [
            'user_id' => auth()->user()->id,  
            'event_id' => $event->id         
        ];
 
        $event->attendees()->attach(auth()->user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Attendee added successfully'
        ], 201);  
    }

     
public function destroy($id, $attendeeId)
{
    $event = Events::find($id);
 

    if (!$event) {
        return response()->json(['message' => 'Event not found'], 404);
    }
 
     
    Attendees::where('id', $attendeeId)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Attendee removed successfully'
    ], 200);
}

}
