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

            session()->flash('success', 'Your email has been confirmed.');
        }else{
            session()->flash('error', 'Confirmation token not registered');
        }

        return redirect('/');
    }
}
