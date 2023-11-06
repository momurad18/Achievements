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
}
