<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Notifications\ResetPasswordNotification;

class ForgotPasswordController extends Controller
{
    /**
     *  Funcation to Genrate Link for Reset Password 
    */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    
        $status = Password::sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                $user->notify(new ResetPasswordNotification($token, $user->email));
            }
        );
    
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent successfully.'], 200);
        }
    
        return response()->json(['error' => trans($status)], 400);
    }
}

