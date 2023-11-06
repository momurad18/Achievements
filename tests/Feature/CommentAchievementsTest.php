<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentAchievementsTest extends TestCase
{
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
}
