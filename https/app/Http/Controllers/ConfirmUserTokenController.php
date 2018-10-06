<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ConfirmUserTokenController extends Controller
{
    public function index()
    {
        $user = User::where('confirm_token', request('token'))->first();
        if($user){
            $user->confirm();

            return redirect('/');
        }

        return abort(404);
    }
}
