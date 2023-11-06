<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Services\UserAchievementService;
use Illuminate\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserAchievementSubscriber
{
    private $achievementService;

    /**
     * Create the event listener.
     *
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
    public function handleLessonWatched(LessonWatched $event)
    {
        $user = $event->user;
        $this->achievementService->unlockAchievements($user, 'lesson', $user->watched()->count());
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommentWritten  $event
     * @return void
     */
    public function handleCommentWritten(CommentWritten $event)
    {
        $user = $event->comment->user;
        $this->achievementService->unlockAchievements($user, 'comment', $user->comments()->count());
    }



    /**
     * Register the listeners for the subscriber.
     *
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            LessonWatched::class => 'handleLessonWatched',
            CommentWritten::class => 'handleCommentWritten',
        ];
    }
}
