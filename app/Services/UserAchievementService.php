<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\Badge;
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
                return $count >= $achievement->required_count;
            })
            ->map->getKey();
            if (count($toUnlock) > 0) {
                $user->unlockAchievements($toUnlock);
            }
    }

    public function unlockBadges (User $user) : void
    {
        $userBadges = $user->badges()->pluck('badge_id');
        $badges = Badge::whereNotIn('id', $userBadges)->get();
        $toUnlock = $badges
            ->filter(function ($badge) use ($user) {
                return $user->achievements()->count() >= $badge->achievement_count;
            })
            ->map->getKey();

        if (count($toUnlock) > 0) {
            $user->unlockBadges($toUnlock);
        }
    }
}
