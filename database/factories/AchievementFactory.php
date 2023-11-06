<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    /**
     * List of achievments mentioned in Test document.
     */
    protected $achievements = [
        ['name' => 'First Lesson Watched', 'type' => 'lesson', 'required_count' => 1],
        ['name' => '5 Lessons Watched', 'type' => 'lesson', 'required_count' => 5],
        ['name' => '10 Lessons Watched', 'type' => 'lesson', 'required_count' => 10],
        ['name' => '25 Lessons Watched', 'type' => 'lesson', 'required_count' => 25],
        ['name' => '50 Lessons Watched', 'type' => 'lesson', 'required_count' => 50],
        ['name' => 'First Comment Written', 'type' => 'comment', 'required_count' => 1],
        ['name' => '3 Comments Written', 'type' => 'comment', 'required_count' => 3],
        ['name' => '5 Comments Written', 'type' => 'comment', 'required_count' => 5],
        ['name' => '10 Comments Written', 'type' => 'comment', 'required_count' => 10],
        ['name' => '20 Comments Written', 'type' => 'comment', 'required_count' => 20],
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $achievement = $this->faker
            ->unique()
            ->randomElement($this->achievements);
        return [
            'name' => $achievement['name'],
            'description' => $this->faker->words(10, true),
            'required_count' => $achievement['required_count'],
            'type' => $achievement['type'],
        ];
    }
}
