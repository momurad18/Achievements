<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Badge>
 */
class BadgeFactory extends Factory
{
    /**
     * List of achievments mentioned in Test document.
     */
    protected $badges = [
        ['name' => 'Beginner','achievement_count' => 0],
        ['name' => 'Intermediate','achievement_count' => 4],
        ['name' => 'Advanced','achievement_count' => 8],
        ['name' => 'Master','achievement_count' => 10],
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $badge = $this->faker
            ->unique()
            ->randomElement($this->badges);
        return [
            'name' => $badge['name'],
            'description' => $this->faker->words(10, true),
            'achievement_count' => $badge['achievement_count'],
        ];
    }
}
