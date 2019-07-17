<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = \App\User::paginate(5); 
 
        $filterKeyword = $request->get('keyword');
        $status = $request->get('status'); 
 
        if($filterKeyword){
            if($status){
                $users = \App\User::where('name', 'LIKE', "%$filterKeyword%")
                                ->Where('status', $status)
                                ->orWhere('username', 'LIKE',"%$filterKeyword%")
                                ->Where('status', $status)
                                ->orWhere('email', 'LIKE',"%$filterKeyword%")
                                ->Where('status', $status)
                                
                                ->paginate(5);    
            }else {
                $users = \App\User::where('name', 'LIKE', "%$filterKeyword%")
                                ->orWhere('username', 'LIKE',"%$filterKeyword%")
                                ->orWhere('email', 'LIKE',"%$filterKeyword%")
                                ->paginate(5);
            }         
            
        }          
        return view('users.index', ['users' => $users]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(),[
            "name" => "required|min:5|max:100",
            "username" => "required|min:5|max:20|unique:users",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200",
            "email" => "required|email|unique:users",
            "password" => "required",
            "password_confirmation" => "required|same:password"
        ])->validate();

        $add_user = new \App\User;
        $add_user->name = $request->get('name');
        $add_user->username = $request->get('username');
        $add_user->roles = json_encode($request->get('roles'));
        $add_user->address = $request->get('address');
        $add_user->phone = $request->get('phone');
        $add_user->email = $request->get('email');
        $add_user->password = \Hash::make($request->get('password'));

        if($request->file('avatar')){
            $file = $request->file('avatar')->store('avatars','public');
            $add_user->avatar = $file;
        }

        $add_user->save();
        return redirect()->route('users.index')->with('status','User successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::findOrFail($id);

        return view('users.detail', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \App\User::findOrFail($id);
        return view('users.edit',['user' => $user]);
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
        $user = \App\User::findOrFail($id);

        \Validator::make($request->all(), [         
            "name" => "required|min:5|max:100",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200",
        ])->validate();
        
        $user->name = $request->get('name');
        $user->roles = json_encode($request->get('roles'));
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->status = $request->get('status');
        if($request->file('avatar')){
            if($user->avatar && file_exists(storage_path('app/public/'.$user->avatar))){
                \Storage::delete('public/'.$user->avatar);
            }
            $file = $request->file('avatar')->store('avatars','public');
            $user->avatar = $file;
        }

        $user->save();
        return redirect()->route('users.index')->with('status','Users successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \App\User::findOrFail($id);

        $user->delete();
        return redirect()->route('users.index')->with('status','User successfully deleted');
    }
}
