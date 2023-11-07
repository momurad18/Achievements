<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return response()->json([
            'unlocked_achievements' => $user->achievements->map->name ?? [],
            'next_available_achievements' => $user->nextAvailableAchievements(),
            'current_badge' => $user->getCurrentBadge()?->name ?? '',
            'next_badge' => $user->getNextBadge()?->name ?? '',
            'remaing_to_unlock_next_badge' => $user->remainingToUnlock()
        ]);
    }
}
