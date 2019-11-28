<?php

namespace App\Http\Controllers\AdminAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191|email|unique:users',
            'password'  => 'required|string|max:191|min:6',
            'phone'  => 'required|string|max:191|min:6|unique:users'
        ]);

        
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  bcrypt($request->password),
            'phone' => $request->phone,
            'status' => $request->status,
            'role' => $request->role,
            'level' => $request->level,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6',
            'phone'  => 'required|string|max:191|min:6|unique:users,phone,'.$user->id,
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->level = $request->level;
        $user->status = $request->status;
        $user->save();
        return ['message' => 'Updated the user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
