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
        $lessonCount = 1;
        $achievementName = 'First Lesson Watched';
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $lessonCount,
            'type' => 'lesson',
        ]);
        $user->lessons()->attach($lesson->id, ['watched' => 1]);
        event(new LessonWatched($lesson, $user));
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

     /**
     * A basic feature test a user can unlock 5 lessons achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_5_lessons_achievement(): void
    {
        $lessonCount = 5;
        $achievementName = "{$lessonCount} Lessons Watched";
        $user = User::factory()->create();
        $lessons = Lesson::factory()
            ->count($lessonCount)
            ->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $lessonCount,
            'type' => 'lesson',
        ]);
        foreach($lessons as $lesson){
            $user->lessons()->attach($lesson->id, ['watched' => 1]);
            event(new LessonWatched($lesson, $user));
        }
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

    /**
     * A basic feature test a user can unlock 10 lessons achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_10_lessons_achievement(): void
    {
        $lessonCount = 10;
        $achievementName = "{$lessonCount} Lessons Watched";
        $user = User::factory()->create();
        $lessons = Lesson::factory()
            ->count($lessonCount)
            ->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $lessonCount,
            'type' => 'lesson',
        ]);
        foreach($lessons as $lesson){
            $user->lessons()->attach($lesson->id, ['watched' => 1]);
            event(new LessonWatched($lesson, $user));
        }
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }
    /**
     * A basic feature test a user can unlock 25 lessons achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_25_lessons_achievement(): void
    {
        $lessonCount = 25;
        $achievementName = "{$lessonCount} Lessons Watched";
        $user = User::factory()->create();
        $lessons = Lesson::factory()
            ->count($lessonCount)
            ->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $lessonCount,
            'type' => 'lesson',
        ]);
        foreach($lessons as $lesson){
            $user->lessons()->attach($lesson->id, ['watched' => 1]);
            event(new LessonWatched($lesson, $user));
        }
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

    /**
     * A basic feature test a user can unlock 50 lessons achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_50_lessons_achievement(): void
    {
        $lessonCount = 50;
        $achievementName = "{$lessonCount} Lessons Watched";
        $user = User::factory()->create();
        $lessons = Lesson::factory()
            ->count($lessonCount)
            ->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $lessonCount,
            'type' => 'lesson',
        ]);
        foreach($lessons as $lesson){
            $user->lessons()->attach($lesson->id, ['watched' => 1]);
            event(new LessonWatched($lesson, $user));
        }
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

}
