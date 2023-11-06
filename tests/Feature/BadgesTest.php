<?php

namespace Tests\Feature;

use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Database\Seeders\BadgeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BadgesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test a user has Beginner badge.
     *
     * @return void
     */
    public function test_a_user_has_beginner_badge(): void
    {
        $badgeName = 'Beginner';
        $achievementCount = 0;
        $user = User::factory()->create();
        $badge = Badge::factory()->create(['name' => $badgeName,'achievement_count' => $achievementCount]);
        $user->unlockBadges([$badge->id]);
        $this->assertCount($achievementCount, $user->achievements);
        $this->assertTrue($user->badges->contains('name', $badgeName), "Failed to assert that the '{$badgeName}' achievement was unlocked.");
    }

    /**
     * A basic feature test a user car earn Intermediate badge.
     *
     * @return void
     */
    public function test_a_user_can_earn_intermediate_badge(): void
    {
        $badgeName = 'Intermediate';
        $achievementCount = 4;
        $user = User::factory()->create();
        $achievements = Achievement::factory()
            ->count($achievementCount)
            ->create();
        $ids = $achievements->pluck('id');
        $badge = Badge::factory()->create(['name' => $badgeName,'achievement_count' => $achievementCount]);
        $user->unlockAchievements($ids);
        $this->assertCount($achievementCount, $user->achievements);
        $this->assertTrue($user->badges->contains('name', $badgeName), "Failed to assert that the '{$badgeName}' achievement was unlocked.");

    }

    /**
     * A basic feature test a user car earn Advanced badge.
     *
     * @return void
     */
    public function test_a_user_can_earn_advanced_badge(): void
    {
        $badgeName = 'Advanced';
        $achievementCount = 8;
        $user = User::factory()->create();
        $achievements = Achievement::factory()
            ->count($achievementCount)
            ->create();
        $ids = $achievements->pluck('id');
        $badge = Badge::factory()->create(['name' => $badgeName,'achievement_count' => $achievementCount]);
        $user->unlockAchievements($ids);
        $this->assertCount($achievementCount, $user->achievements);
        $this->assertTrue($user->badges->contains('name', $badgeName), "Failed to assert that the '{$badgeName}' achievement was unlocked.");
    }

    /**
     * A basic feature test a user car earn Master badge.
     *
     * @return void
     */
    public function test_a_user_can_earn_master_badge()
    {
        $badgeName = 'Master';
        $achievementCount = 10;
        $user = User::factory()->create();
        $achievements = Achievement::factory()
            ->count($achievementCount)
            ->create();
        $ids = $achievements->pluck('id');
        $badge = Badge::factory()->create(['name' => $badgeName,'achievement_count' => $achievementCount]);
        $user->unlockAchievements($ids);
        $this->assertCount($achievementCount, $user->achievements);
        $this->assertTrue($user->badges->contains('name', $badgeName), "Failed to assert that the '{$badgeName}' achievement was unlocked.");
    }

    /**
     * A basic feature test a badge unlocked dispatched.
     *
     * @return void
     */
    public function test_a_badge_unlocked_dispatched()
    {
        $this->seed(BadgeSeeder::class);
        Event::fake(BadgeUnlocked::class);
        $achievementCount = 10;
        $user = User::factory()->create();
        $achievements = Achievement::factory()
            ->count($achievementCount)
            ->create();
        $ids = $achievements->pluck('id');
        $user->unlockAchievements($ids);
        Event::assertDispatched(BadgeUnlocked::class, function ($event) use ($user) {
            return $event->user->is($user);
        });

    }

    /**
     * A basic feature test a badge unlocked dispatched.
     *
     * @return void
     */
    public function test_a_badge_unlocked_dispatched_n_of_times()
    {
        $this->seed(BadgeSeeder::class);
        Event::fake(BadgeUnlocked::class);
        $achievementCount = 4;
        $badgeCount = 2;
        $user = User::factory()->create();
        $achievements = Achievement::factory()
            ->count($achievementCount)
            ->create();
        $ids = $achievements->pluck('id');
        $user->unlockAchievements($ids);
        Event::assertDispatchedTimes(BadgeUnlocked::class, $badgeCount);
    }

}
