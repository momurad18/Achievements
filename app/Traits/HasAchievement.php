<?php

namespace App\Traits;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;

trait HasAchievement
{
    public function unlockAchievements($ids)
    {
        foreach ($ids as $id) {
            $achievement = Achievement::findOrFail($id);
            $this->achievements()->attach($achievement->id);
            AchievementUnlocked::dispatch($achievement->name, $this);
        }
    }

    public function unlockBadges($ids)
    {
        foreach ($ids as $id) {
            $badge = Badge::findOrFail($id);
            $this->badges()->attach($badge->id);
            BadgeUnlocked::dispatch($badge->name, $this);
        }
    }
}
