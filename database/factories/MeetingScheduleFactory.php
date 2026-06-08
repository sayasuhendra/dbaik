<?php

namespace Database\Factories;

use App\Models\MeetingSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MeetingSchedule>
 */
class MeetingScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => fake()->name(),
            'client_email' => fake()->safeEmail(),
            'client_phone' => fake()->phoneNumber(),
            'topic' => fake()->sentence(),
            'meeting_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'meeting_time' => fake()->time('H:i'),
            'status' => 'pending',
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
