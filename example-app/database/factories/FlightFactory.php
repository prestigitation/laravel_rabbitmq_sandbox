<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    private function justifyTime(Carbon &$time) {
        $currentMinutes = $time->minute;

        if ($currentMinutes < 15) {
            $roundedMinutes = 0;
        } elseif ($currentMinutes < 45) {
            $roundedMinutes = 30;
        } else {
            $roundedMinutes = 0;
            $time->addHour();
        }

        $time->setMinutes($roundedMinutes);
        $time->setSeconds(0);

        return $time;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = Carbon::now()->addDays(rand(0, 2))->addHours(rand(0,5))->addSeconds(rand(0, 43200));
        $startTime = $this->justifyTime($start);
        $end = $startTime->clone()->addSeconds(rand(0, 43200));
        $endTime = $this->justifyTime($end);

        return [
            "from" => fake()->city(),
            "to" => fake()->city(),
            "start_time" => $startTime,
            "end_time" => $endTime,
            "company_id" => rand(1,10)
        ];
    }
}
