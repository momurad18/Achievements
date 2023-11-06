<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BadgesTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_earn_intermediate_badge()
    {
        $user = User::factory()->create();
        $achievements = Achievement::factory()
            ->count(4)
            ->create();
        $ids = $achievements->pluck('id');
        $badges = Badge::factory()->create(['achievement_count' => 4]);
        $user->unlockAchievements($ids);
        $this->assertCount(4, $user->achievements);
        $this->assertCount(1, $user->badges);
    }
}
