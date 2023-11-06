<?php

namespace App\Listeners;


use App\Events\LessonWatched;
use App\Services\UserAchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockLessonAchievements
{
    private $achievementService;

    /**
     * Create the event listener.
     *
     * @param  \App\Services\UserAchievementService  $achievementService
     * @return void
     */
    public function __construct(UserAchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event) : void
    {
        $user = $event->user;
        $this->achievementService->unlockAchievements($user, 'lesson', $user->watched()->count());
    }
}
