<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\Auth\Entity\Email;
use App\Model\Auth\Entity\User;
use App\Model\Auth\Repository\UserRepository;
use App\Model\Auth\UseCase\UserService;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;
use Mail;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * @var UserService
     */
    private UserService $userService;
    /**
     * @var UserRepository
     */
    private UserRepository $users;

    public function __construct(UserService $userService, UserRepository $users)
    {
        $this->userService = $userService;
        $this->users = $users;
    }

    public function showLinkRequestForm()
    {
        return view('app.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        try {
            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );

            return $response == 'passwords.sent'
                ? redirect()->route('auth.password.requested')
                : $this->sendResetLinkFailedResponse($request, $response);
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => $e->getMessage()]);
        }
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
    }
}
