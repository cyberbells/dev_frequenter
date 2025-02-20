<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /**
     * Show Reset Password Form to EndUser 
    */
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->token, 'email' => $request->email]);
    }
    
    /**
     *  Reset Password API Funcation // Validations 
    */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
    
                $user->tokens()->delete(); // Delete old tokens
            }
        );
    
        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'error' => 'Password reset failed'
            ], 400);
        }
    
        return response()->json(['message' => 'Password has been reset successfully.'], 200);
    
    }
}

