<?php

namespace App\Http\Controllers;

use App\Events\SendLikeEvent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user)
    {
        return inertia('User/Show', compact('user'));
    }

    public function sendLike(User $user)
    {
        $str_message = 'Новый лайк для #' . $user->id . ' от #' . Auth::id();
        broadcast(new SendLikeEvent($str_message, $user->id))->toOthers();
        return response()->json([
            'like_str' => $str_message
        ]);
    }
}
