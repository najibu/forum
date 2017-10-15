<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }

    protected function getActivity(User $user)
    {
        $activities =  $user->activity()
                ->latest()
                ->with('subject')
                ->take(50)
                ->get()
                ->groupBy(function ($activity) {
                    return $activity->created_at->format('Y-m-d');
                });

        return $activities;
    }
}
