<?php

namespace Database\Factories;

use App\Models\AdvertisingCampaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisingCampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdvertisingCampaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'from_date' => now()->format('Y-m-d'),
            'to_date' => now()->addYear()->format('Y-m-d'),
            'daily_budget' => rand(30, 80),
            'total_budget' => rand(3000, 8000),
            'image_path' => $this->faker->imageUrl($width = 200, $height = 200)
        ];
    }
}
