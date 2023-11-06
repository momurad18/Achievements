<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockCommentAchievements
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
     */
    public function handle(CommentWritten $event): void
    {
        $userAchievements = $event->comment->user
            ->achievements()
            ->where('type', 'comment')
            ->pluck('achievement_id');
        $achievements = Achievement::where('type', 'comment')
            ->whereNotIn('id', $userAchievements)
            ->get();
        $toUnlock = $achievements
            ->filter(function ($achievement) use ($event) {
                return $event->comment->user->comments()->count() >=
                    $achievement->required_count;
            })
            ->map->getKey();
        if (count($toUnlock) > 0) {
            foreach ($toUnlock as $id) {
                $achievement = Achievement::findOrFail($id);
                $event->comment->user->achievements()->attach($achievement->id);
                AchievementUnlocked::dispatch($achievement->name, $event->comment->user);
            }
        }
    }
}
