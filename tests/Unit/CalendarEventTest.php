<?php

namespace Tests\Unit;

use App\CalendarEvent;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarEventTest extends TestCase
{
    /**
     * A unit test for listing calendar events if we can list
     *
     * @return void
     */
    public function test_can_list_calendar_events()
    {
    	$calendar_events = factory(CalendarEvent::class, 2)->create()->map(function ($calendar_event) {
    		return $calendar_event->only(['id', 'event_name', 'event_days', 'start_date', 'end_date']);
    	});
    	$response = $this->get(route('calendarEvents.list'))
		->assertStatus(200)
		->assertJsonStructure([
			'id', 'event_name', 'event_days', 'start_date', 'end_date'
		]);
    }

    /**
     * A unit test for saving events in the database if we can save
     *
     */
    public function test_can_save_calendar_events() {
    	$min = 0;
		$max = rand(0,6);
		$event_days = range($min, $max);
		$event_days = array_map('strval', $event_days);
		$end_date = date($format = 'Y-m-d', strtotime('now +' . rand(0,30) . 'days'));
		$start_date = date($format = 'Y-m-d', strtotime($end_date . ' -' . rand(0,20) . 'days'));
    	$data = [
    		'event_name' => substr($this->faker->text, 0, 10),
    		'event_days' => $event_days,
    		'event_date_range' => [
    			'start_date' => $start_date,
    			'end_date' => $end_date
    		]
    	];
    	$response = $this->withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
        ])
        ->json('POST', route('calendarEvents.list'), $data)//post(route('calendarEvents.list'), $data)
		->assertStatus(200);
    }

}
