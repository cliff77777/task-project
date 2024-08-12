<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;


use function PHPSTORM_META\type;

class UserManageController extends Controller
{
    //
    public function index(){
        $users=User::paginate(10);
        return view('user_manage.index',compact('users'));
    }

    public function show($id){

        $user=User::find($id);
        
        return view('user_manage.show',compact('user'));
    }

    public function create(){

        $user_role=UserRole::get();

        return view('user_manage.create',compact('user_role'));

    }

    public function store(Request $request){

        Log::info([
            'all'=>$request->all()
        ]);

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'=>['required'],
        ])->validate();

        
        try{
            $user=new User;
            $user->updated_by=Auth::id();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=$request->password;
            $user->role=$request->role;
            // 創建訪問令牌
            $user->createToken('YourAppName')->accessToken;
            $user->save();
            // 寄出信箱驗證信
            $user->sendEmailVerificationNotification();

            return redirect()->route('user_manage.index')->with('success','We sent  an activation code. please Check the email and click on the link to verify.');
        }catch(\Exception $e){
            Log::info($e);
            return redirect()->back()->with("message","create user fail ".$e);
        }
        

    }


    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required',
        ]);

        try{
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->role = $request->input('role');
            $user->password = $request->input('password'); 
            $user->updated_by = Auth::id();
            $user->save();
            return redirect()->back()->with('success','user info updte success');

        }catch(\Exception $e){
            return redirect()->back()->with('error','user info updte fail '.$e);
        }

    }

    public function edit($id){
        $user=User::find($id);
        $user_role=UserRole::get();

        return view('user_manage.edit',compact('user','user_role'));
    }

    public function password_check(Request  $request ,User $user){

        $check_result=$user->find($request->id)->checkPassword($request->origin_password);

        if ($check_result) {
            // 密碼正確，執行相應的邏輯
            return response()->json(['message' => 'Password is correct.']);
        } else {
            // 密碼錯誤，返回錯誤信息
            return response()->json(['message' => 'Password is incorrect.'], 401);
        }
    }

    public function destory(){

    }


}
