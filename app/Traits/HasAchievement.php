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

    /**
     * Get the model's current badge.
     *
     * @return Badge|null
     */
    public function getCurrentBadge(): ?Badge
    {
        $currentBadge = $this->badges()
            ->orderBy('achievement_count', 'desc')
            ->first();
        if (!$currentBadge && !$this->achievements->count()) {
            $badgeId = Badge::where('achievement_count', 0)->first()->id ?? null;
            $this->badges()->attach($badgeId);
            $currentBadge = $this->badges->first();
        }

        return $currentBadge;
    }
    /**
     * Get the model's next badge.
     *
     * @return Badge|null
     */
    public function getNextBadge(): ?Badge
    {
        $currentBadgePoints = $this->badges->max('achievement_count') ?? 0;
        return Badge::where([['achievement_count', '>', $currentBadgePoints]])
            ->orderBy('achievement_count', 'asc')
            ->first();
    }
    /**
     * Get the next available achievements for the model.
     *
     * @return array
     */
    public function nextAvailableAchievements(): array
    {
        return array_values(array_filter([
            $this->nextAchievementByType('lesson'),
            $this->nextAchievementByType('comment'),
        ]));
    }

    /**
     * Get the remaing achievements to Unloack next badge.
     *
     * @return int
     */
    public function remaingToUnloack(): int
    {
        return ($this->getNextBadge()->achievement_count ?? 0) - $this->achievements->count();
    }

    /**
     * Get the next available achievement by type for the model.
     *
     * @param  string  $type
     * @return string|null
     */
    private function nextAchievementByType(string $type): ?string
    {
        $maxPoints = $this->achievements->where('type', $type)->max('required_count') ?? 0;
        return Achievement::where('type', $type)
            ->where('required_count', '>', $maxPoints)
            ->orderBy('required_count')->first()->name ?? null;
    }
}
