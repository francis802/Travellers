<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\MailModel;

use Mail;
use App\Models\User;

use Illuminate\View\View;

class RecoveryController extends Controller {

    public function show() {
        return view('auth.recovery');
    }

    public function recoverPassword(Request $request) {

        $user = User::where('email', '=', $request->recoverAttemp)->first();
        if (!$user) return redirect()->back()->with('error', "Invalid email");

        if (Hash::check($request->recoverToken, $user->password)) {

            if ($request->recoverPassword1 != $request->recoverPassword2) {
                return redirect()->back()->with('match_error', "Passwords don't match")
                                ->with('email_attemp', $request->recoverAttemp);
            }

            if (strlen($request->recoverPassword1) < 8) {
                return redirect()->back()->with('size_error', "Password must be at least 8 characters")
                                ->with('email_attemp', $request->recoverAttemp);
            }
            
            $user->password = bcrypt($request->recoverPassword1);
            $user->save();
            return redirect()->route('login')->with('success', "Your password has been changed successfully");
        }
        return redirect()->back()->with('invalid_token', "Invalid token. Please try again.")
                                        ->with('email_attemp', $request->recoverAttemp);
    }

    protected function generateRandomToken(int $length) {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function sendEmail(Request $request) {

        $user = User::where('email', '=', $request->email)->first();
        if ($user) {

            $token = $this->generateRandomToken(8);

            $mailData = array(  'name' => $user->name,
                                'username' => $user->username, 
                                'token' => $token               );

            Mail::to($request->email)->send(new MailModel($mailData));

            $user->password = bcrypt($token);
            $user->save();

            return redirect()->back();
        }
    }

}
