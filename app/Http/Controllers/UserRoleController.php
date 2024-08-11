<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user_role = UserRole::with('username')->paginate(10);

        return view('user_role.index',compact('user_role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('user_role.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request ,UserRole $user_rol)
    {
        $request->validate([
            'user_role_name' => 'required|string|max:255',
            'user_role_descript' => 'required|string|max:255',
        ]);

        $create_content=[
            "role_name"=>$request->user_role_name,
            "role_control"=>json_encode($request->role_control),
            "role_descript"=>$request->user_role_descript,
            "created_by"=>Auth::id(),
            "updated_by"=>Auth::id()
        ];
        Log::debug([
            'create_content'=>$create_content,
            'user_role'=>$request->all()]
        );

        try{
        UserRole::create($create_content);
        }catch(\Exception $e){
            Log::debug('user_role add fail'.$e);
            return redirect()->route('user_role.index')->with('error', '權限新增失敗');
        }
        return redirect()->route('user_role.index')->with('success', '權限已新增');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role=UserRole::find($id);
        $users=User::where(['role'=>$role->role_name])->select('name','role','created_at')->paginate(10);

        return view('user_role.show',compact('role','users'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $role=UserRole::find($id);

    return view('user_role.edit',compact('role'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,UserRole $user_role)
    {
        $this->authorize('update', $user_role);

        try{
            $user_role->update([
                'role_name'=>$request->role_name,
                'role_descript'=>$request->role_descript,
                // 'role_control'=>$request->role_control, //待修改
                'updated_by'=>Auth::id()
                
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with('error','User role update error'.$e);
        }
        
        return redirect()->route('user_role.index')->with('success','User role update success');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRole $userRole)
    {
        //
    }
}
