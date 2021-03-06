<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        return view('profile')->withUser($user)
            ->withSeries($user->getSeriesBeingWatched());
    }
}
