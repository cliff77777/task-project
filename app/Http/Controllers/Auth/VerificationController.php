<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

        /**
     * Resend the email verification notification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        try {
            if ($request->user()->hasVerifiedEmail()) {
                setSessionMessageFromStatusCode('success','email_verified');
            }else{
                $request->user()->sendEmailVerificationNotification();
                setSessionMessageFromStatusCode('success','verification_link_sent');
            }
            return redirect()->route('home');
        }catch (\Exception $e) {
            Log::error('Failed to send verification email: ' . $e->getMessage());
            setSessionMessageFromStatusCode('error','send_verifity_fail');
            return redirect()->route('error.error_index');
        }
    }
}
