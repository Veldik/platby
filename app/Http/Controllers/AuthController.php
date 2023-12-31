<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Mail\UserChangePassword;
use App\Models\PasswordReset;
use App\Models\Payer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken('authToken')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $authToken]);
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            $payer = Payer::where('email', $validated['email'])->first();
            if (!$payer) {
                return response()->json(['message' => 'You must be payer if you want to change password.'], 401);
            }

            $validated = [
                'name' => $payer->fullName(),
                'password' => Hash::make(Str::random(30)),
                'email' => $payer->email,
            ];

            User::create($validated);
        }

        $passwordReset = PasswordReset::where('email', $validated['email'])->first();
        if (isset($passwordReset)) {
            if ($passwordReset->created_at > Carbon::now()->subMinutes(2)) {
                return response()->json(['message' => 'Email byl již odeslán, musíš chvíli počket před odesláním dalšího.'], 400);
            }
            PasswordReset::where('email', $validated['email'])->delete();
        }

        $passwordReset = new PasswordReset;
        $passwordReset->email = $validated['email'];
        $passwordReset->save();
        Mail::to($validated['email'])->send(new UserChangePassword($passwordReset->token));

        return response()->json(['status' => 'ok']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();

        $passwordReset = PasswordReset::where('token', $validated['token'])->first();

        if (isset($passwordReset)) {
            if (!$passwordReset && $passwordReset->created_at < Carbon::now()->subMinutes(60)) {
                return response()->json(['message' => 'Odkaz pro obnovu hesla vypršel.'], 400);
            }
        } else {
            return response()->json(['message' => 'Odkaz pro obnovu hesla není platný.'], 400);
        }

        $user = User::where('email', $passwordReset->email)->first();
        $user->password = Hash::make($validated["password"]);
        $user->save();
        PasswordReset::where('email', $passwordReset->email)->delete();

        return response()->json(['status' => 'ok']);
    }
}
