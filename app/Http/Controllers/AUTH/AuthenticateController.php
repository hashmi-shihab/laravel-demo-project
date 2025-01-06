<?php

namespace App\Http\Controllers\AUTH;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebLoginRequest;
use App\Jobs\SendEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;



class AuthenticateController extends Controller
{
    public function loginPage()
    {
        return view('admin.login');

    }

    public function login(WebLoginRequest $request)
    {
        $request->merge([
            'identifier' => trim(strtolower($request->identifier)),
            'password' => trim($request->password)
        ]);

        $user = User::whereRaw('LOWER(TRIM(email)) = ?', [$request->identifier])
            ->orWhereRaw('LOWER(TRIM(user_name)) = ?', [$request->identifier])
            ->orWhereRaw('TRIM(user_mobile) = ?', [$request->identifier])
            ->first();

        if (!$user) {
            return back()->with('error', 'No account found with these credentials.');
        }

        $credentials = [
            'email' => $user->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('Dashboard');
        }

        throw ValidationException::withMessages([
            'password' => ['The provided password is incorrect.'],
        ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function showForgetPasswordForm()
    {
        return view('forgotPassword.passwordResetFrom');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users',
            ]);

            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]
            );

            $resetLink = url('/reset-password/' . $token);

            $data = [
                'blade' => 'email.passwordResetLink',
                'to' => str_replace(' ', '', $request->email),
                'subject' => 'Reset Password',
                'from' => 'noreply@xyz.com',
                'from-head' => 'XYZ || XYZ Technologies Limited',
                'reset_link' => $resetLink,
            ];
            $send_email = new SendEmail($data);
            $send_email->handle();

            return back()->with('message', 'We have e-mailed your password reset link!');

        }catch (\Throwable $th){
            dd($th->getMessage());
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function showResetPasswordForm($token)
    {
        return view('forgotPassword.passwordReset', ['token' => $token]);

    }

    public function submitResetPasswordForm(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:4|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

        return redirect('login')->with('message', 'Your password has been changed!');

    }
}
