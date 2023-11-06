<?php

namespace Tests\Feature;

use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonAchievementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test a user can unlock first lesson achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_first_lesson_achievement(): void
    {
        $achievementName = 'First Lesson Watched';
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->lessons()->attach($lesson->id, ['watched' => 1]);
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => 1,
            'type' => 'lesson',
        ]);
        event(new LessonWatched($lesson, $user));
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }
}
