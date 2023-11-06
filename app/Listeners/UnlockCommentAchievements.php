<?php

namespace App\Listeners;


use App\Events\CommentWritten;
use App\Services\UserAchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockCommentAchievements
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
     *
     * @param  \App\Events\CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event): void
    {
        $user = $event->comment->user;
        $this->achievementService->unlockAchievements($user, 'comment', $user->comments()->count());
    }
}
