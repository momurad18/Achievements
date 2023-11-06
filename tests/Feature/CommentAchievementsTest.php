<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentAchievementsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test a user can unlock first comment written achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_first_comment_written(): void
    {
        $commentCount = 1;
        $achievementName = 'First Comment Written';
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $commentCount,
            'type' => 'comment',
        ]);
        $comment = Comment::factory()->create(['user_id' => $user->id]);
        event(new CommentWritten($comment));
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

    /**
     * A basic feature test a user can unlock 3 comments written achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_3_comments_written(): void
    {
        $commentCount = 3;
        $achievementName = "{$commentCount} Comments Written";
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $commentCount,
            'type' => 'comment',
        ]);
        for ($i = 0; $i < $commentCount; $i++) {
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            event(new CommentWritten($comment));
        }
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

    /**
     * A basic feature test a user can unlock 5 comments written achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_5_comments_written(): void
    {
        $commentCount = 5;
        $achievementName = "{$commentCount} Comments Written";
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $commentCount,
            'type' => 'comment',
        ]);
        for ($i = 0; $i < $commentCount; $i++) {
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            event(new CommentWritten($comment));
        }
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

     /**
     * A basic feature test a user can unlock 10 comments written achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_10_comments_written(): void
    {
        $commentCount = 10;
        $achievementName = "{$commentCount} Comments Written";
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $commentCount,
            'type' => 'comment',
        ]);
        for ($i = 0; $i < $commentCount; $i++) {
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            event(new CommentWritten($comment));
        }
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

     /**
     * A basic feature test a user can unlock 20 comments written achievement.
     *
     * @return void
     */
    public function test_a_user_can_unlock_20_comments_written(): void
    {
        $commentCount = 20;
        $achievementName = "{$commentCount} Comments Written";
        $user = User::factory()->create();
        $achievement = Achievement::factory()->create([
            'name' => $achievementName,
            'required_count' => $commentCount,
            'type' => 'comment',
        ]);
        for ($i = 0; $i < $commentCount; $i++) {
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            event(new CommentWritten($comment));
        }
        $this->assertTrue($user->achievements->contains('name', $achievementName), "Failed to assert that the '{$achievementName}' achievement was unlocked.");
    }

    /**
     * A basic feature test a comment achievement unlocked dispatched.
     *
     * @return void
     */
    public function test_a_comment_achievement_unlocked_dispatched()
    {
        $this->seed(AchievementSeeder::class);
        $commentCount = 1;
        Event::fake(AchievementUnlocked::class);
        $user = User::factory()->create();
        for ($i = 0; $i < $commentCount; $i++) {
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            event(new CommentWritten($comment));
        }
        Event::assertDispatched(AchievementUnlocked::class, function ($event) use ($user) {
            return $event->user->is($user);
        });

    }

    /**
     * A basic feature test a comment achievement unlocked dispatched n of times.
     *
     * @return void
     */
    public function test_a_comment_achievement_unlocked_dispatched_n_of_times()
    {
        $this->seed(AchievementSeeder::class);
        $commentCount = 20;
        $achievementCount = 5;
        Event::fake(AchievementUnlocked::class);
        $user = User::factory()->create();
        for ($i = 0; $i < $commentCount; $i++) {
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            event(new CommentWritten($comment));
        }
        Event::assertDispatchedTimes(AchievementUnlocked::class, $achievementCount);
    }
}
