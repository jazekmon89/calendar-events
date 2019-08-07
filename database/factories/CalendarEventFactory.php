
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\CalendarEvent;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(CalendarEvent::class, function (Faker $faker) {
    $event_days = range(0, rand(0,6));
    $event_days = array_map('strval', $event_days);
    $event_days = json_encode($event_days);
    $end_date = date($format = 'Y-m-d', strtotime('now +' . rand(0,30) . 'days'));
    $start_date = date($format = 'Y-m-d', strtotime($end_date . ' -' . rand(0,20) . 'days'));
    return [
        'event_name' => substr($faker->text, 0, 10),
        'event_days' => $event_days,
        'start_date' => $start_date,
        'end_date' => $end_date
    ];
});