<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->User = $user;
        $genders = User::getGenders();
        view()->share(compact('genders'));
    }
    public function information()
    {
        $users = User::where('email', Auth::user()->email)->paginate(5);
        return view('user.information', ['users' => $users]);
    }
}
