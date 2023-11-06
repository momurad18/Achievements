<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;

class UserAchievementService
{
    public function unlockAchievements (User $user, string $type, int $count) : void
    {
        $userAchievements = $user
            ->achievements()
            ->where('type', $type)
            ->pluck('achievement_id');

        $achievements = Achievement::where('type', $type)
            ->whereNotIn('id', $userAchievements)
            ->get();

        $toUnlock = $achievements
            ->filter(function ($achievement) use ($count) {
                return $count >= $achievement->points;
            })
            ->map->getKey();
        $user->unlockAchievements($toUnlock);
    }
}
