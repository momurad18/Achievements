<?php

namespace App\Traits;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;

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
}
