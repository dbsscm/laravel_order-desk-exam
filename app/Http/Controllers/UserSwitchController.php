<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Exam convenience only. Switching users stands in for logging in
 * and is out of scope for the exam.
 */
class UserSwitchController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        session(['current_user_id' => (int) $data['user_id']]);
        session()->forget('cart');

        return redirect()->route('products.index');
    }
}
