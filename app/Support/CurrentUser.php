<?php

namespace App\Support;

use App\Models\User;

/**
 * Exam convenience only: the "logged in" user is whoever is selected
 * in the user switcher. There is no real authentication in this app.
 */
class CurrentUser
{
    private static ?User $user = null;

    public static function get(): User
    {
        if (self::$user === null) {
            $id = session('current_user_id');

            self::$user = User::find($id) ?? User::orderBy('id')->firstOrFail();

            session(['current_user_id' => self::$user->id]);
        }

        return self::$user;
    }
}
