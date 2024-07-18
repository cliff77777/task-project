<?php

namespace App\Http\Controllers\Auth;

use App\Models\User; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;



class RegisterController extends Controller
{
        public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $register_rule=
        [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed'
        ];

        // $register_error_message=[
        //     'name.required' => '',
        // ];

        $validator = Validator::make($request->all(),$register_rule);

        // Log::debug('test');

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = $this->create($request->all());

        event(new Registered($user));

        return redirect('/login')->with('status', 'We have sent you an activation link. Check your email and click on the link to verify.');
    }

    public function checkEmail($email)
    {
        $exists = User::where('email', $email)->exists();
        return response()->json(['exists' => $exists]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
