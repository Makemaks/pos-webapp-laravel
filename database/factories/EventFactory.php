<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'event_account_id'   => 1,
            'event_user_id'      => 1,
            'event_name'         => $this->faker->word(),
            'event_description'  => $this->faker->text(200),
            'event_note'         => ['user_id' => 1, 'description' => $this->faker->text(200), 'created_at' => time()],
            'event_ticket'       => ['name' => $this->faker->word(), 'type' => $this->faker->randomElement(Event::ticketType()), 'quantity' => $this->faker->numberBetween($min = 1, $max = 200), 'cost' => $this->faker->numberBetween($min = 1, $max = 200), 'row' => ''],
            'event_file'         => ['user_id' => '', 'name' => '', 'location' => '', 'type' => ''],
            'event_floorplan'    => ['setting_building_id' => 1, 'setting_room_id' => 1],
        ];
    }
}
