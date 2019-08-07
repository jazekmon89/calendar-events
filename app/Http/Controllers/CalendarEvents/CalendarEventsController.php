<?php

namespace App\Http\Controllers\CalendarEvents;

use App\CalendarEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarEventPost;
use Illuminate\Http\Request;

class CalendarEventsController extends Controller
{

    public function index() {
        $calendar_events = CalendarEvent::orderBy('id', 'desc')->first();
        return response()->json($calendar_events, 200);
    }

    public function store(CalendarEventPost $request) {
        $data = $request->all();
        $event_name = $data['event_name'];
        $event_days = json_encode($data['event_days']);
        $event_start_date = json_encode($data['event_date_range']['start_date']);
        $event_end_date = json_encode($data['event_date_range']['end_date']);
        CalendarEvent::create([
            'event_name' => $event_name,
            'event_days' => $event_days,
            'start_date' => $event_start_date,
            'end_date' => $event_end_date
        ]);
        return response()->json(['success' => 1], 200);
    }

}
?>