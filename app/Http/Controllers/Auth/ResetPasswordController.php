<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\Auth\UseCase\UserService;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    use ResetsPasswords;

    protected $redirectTo = RouteServiceProvider::HOME;

    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'token'
        );
    }

    public function showResetForm(Request $request, $token = null)
    {
        $request->merge(['token' => $token, 'password' => 'dummy']);

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $user->setRememberToken(Str::random(60));
                event(new PasswordReset($user));

                $password = $this->userService->setRandomPassword($user);
                $this->guard()->login($user);

                \Mail::raw("Your new password: {$password}", function ($message) use($user) {
                    $message->to($user->email)->subject('New password');
                });

                return view('app.auth.passwords.success', ['email' => $user->email]);
            }
        );

        return $this->sendResetFailedResponse($request, $response);
    }
}
