<?php

namespace Tests\Feature;

use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Lesson;
use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AchievementsEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test the application returns a successful response.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed([BadgeSeeder::class, AchievementSeeder::class]);
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
    }

    /**
     * A basic feature test the application returns correct keys and values when user has 0 achievement.
     *
     * @return void
     */
    public function test_the_application_returns_correct_keys_and_values_when_user_has_0_achievement(): void
    {
        $this->seed([BadgeSeeder::class, AchievementSeeder::class]);
        $user = User::factory()->create();
        $expectedResponse = [
            "unlocked_achievements" => [],
            "next_available_achievements" => [
                "First Lesson Watched",
                "First Comment Written"
            ],
            "current_badge" => "Beginner",
            "next_badge" => "Intermediate",
            "remaing_to_unlock_next_badge" => 4
        ];
        $response = $this->actingAs($user)->getJson("/users/{$user->id}/achievements");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'unlocked_achievements',
            'next_available_achievements',
            'current_badge',
            'next_badge',
            'remaing_to_unlock_next_badge'
        ]);
        $response->assertJson($expectedResponse);

    }

    /**
     * A basic feature test the application returns correct keys and values when user has 5 achievements.
     *
     * @return void
     */
    public function test_the_application_returns_correct_keys_and_values_when_user_has_5_achievements(): void
    {
        $this->seed([BadgeSeeder::class, AchievementSeeder::class]);
        $user = User::factory()->create();
        $lessons = Lesson::factory()->count(50)->create();
        foreach($lessons as $lesson){
            $user->lessons()->attach($lesson->id, ['watched' => 1]);
            event(new LessonWatched($lesson, $user));
        }
        $expectedResponse = [
            "unlocked_achievements" => [
                "First Lesson Watched",
                "5 Lessons Watched",
                "10 Lessons Watched",
                "25 Lessons Watched",
                "50 Lessons Watched"
            ],
            "next_available_achievements" => [
                "First Comment Written"
            ],
            "current_badge" => "Intermediate",
            "next_badge" => "Advanced",
            "remaing_to_unlock_next_badge" => 3
            ];
        $response = $this->actingAs($user)->getJson("/users/{$user->id}/achievements");
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'unlocked_achievements',
            'next_available_achievements',
            'current_badge',
            'next_badge',
            'remaing_to_unlock_next_badge'
        ]);
        $response->assertJson($expectedResponse);

    }

    /**
     * A basic feature test the application returns correct keys and values when user unlocked all achievements.
     *
     * @return void
     */
    public function test_the_application_returns_correct_keys_and_values_when_user_unlocked_all_achievements(): void
    {
        $this->seed([BadgeSeeder::class, AchievementSeeder::class]);
        $user = User::factory()->create();
        $achievements = Achievement::all()->sortBy([
            ['required_count', 'asc'],
            ['type', 'asc']
        ])->pluck('id');
        $user->unlockAchievements($achievements);
        $expectedResponse = [
            "unlocked_achievements" => [
                "First Comment Written",
                "First Lesson Watched",
                "3 Comments Written",
                "5 Comments Written",
                "5 Lessons Watched",
                "10 Comments Written",
                "10 Lessons Watched",
                "20 Comments Written",
                "25 Lessons Watched",
                "50 Lessons Watched"
            ],
            "next_available_achievements" => [],
            "current_badge" => "Master",
            "next_badge" => "",
            "remaing_to_unlock_next_badge" => 0
            ];
        $response = $this->actingAs($user)->getJson("/users/{$user->id}/achievements");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'unlocked_achievements',
            'next_available_achievements',
            'current_badge',
            'next_badge',
            'remaing_to_unlock_next_badge'
        ]);
        $response->assertJson($expectedResponse);

    }

}
