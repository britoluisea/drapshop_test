<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getUser()
    {
        $user = Auth::user();
        return response()->json(['user'=>$user]);
    }     
    public function changePass(Request $request)
    {
        $request->validate([
            'new_password' => ['required'],
            'confirm_password' => ['same:new_password'],
        ]);       
        $data = [  
            'password' => Hash::make($request->new_password),
        ];
        $r =User::where('id', $request['id'])->update($data); 
        return response()->json(['status' => ($r),], 200);  
    } 
    public function editAccount(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required'],
        ]);       
        $data = [  
            'name' => $request->name,
            'email' => $request->email,
        ];
        $r =User::where('id', $request['id'])->update($data); 
        $user =User::where('id', $request['id'])->first(); 
        return response()->json([
            'status' => ($r),
            'user' => $user,
        ], 200);  
    }
}
