<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Models\Badge;
use App\Services\UserAchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockBadges
{
    private $achievementService;
    /**
     * Create the event listener.
     *
     * @param  \App\Services\UserAchievementService  $achievementService
     */
    public function __construct(UserAchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    /**
     * Handle the event.
     */
    public function handle(AchievementUnlocked $event): void
    {
        $user = $event->user;
        $this->achievementService->unlockBadges($user);

    }
}
