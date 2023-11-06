<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockLessonAchievements
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(LessonWatched $event): void
    {
        $userAchievements = $event->user
            ->achievements()
            ->where('type', 'lesson')
            ->pluck('achievement_id');

        $achievements = Achievement::where('type', 'lesson')
            ->whereNotIn('id', $userAchievements)
            ->get();
        $toUnlock = $achievements
            ->filter(function ($achievement) use ($event) {
                return $event->user->watched()->count() >= $achievement->required_count;
            })
            ->map->getKey();
        if (count($toUnlock) > 0) {
            foreach ($toUnlock as $id) {
                $achievement = Achievement::findOrFail($id);
                $event->user->achievements()->attach($achievement->id);
                AchievementUnlocked::dispatch($achievement->name, $event->user);
            }
        }
    }
}
