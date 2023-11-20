<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class VerifyEmailController extends Controller
{

    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
             return view('partials.page', [
                    'message' => 'Email already verified'
                ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return view('partials.page', [
                    'message' => 'Successfully verified'
                ]);
    }
}