<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodBank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function login(Request $request){
        $admin = Admin::where('email', '=', $request->email)->get();
        if ($request->password == $admin->password){
            return response()->json(['message' => 'login successful', 'code' => 200]);
        }
        else{
            return response()->json(['message' => 'wrong login details', 'code' => 501]);
        }
    }

    public function signup(Request $request){
        $user = new Admin();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json(['message' => 'registration successful', 'code' => 200]);
    }

    public function list_users(){
        $users = User::all();
        return response()->json($users);
    }

    public function list_banks()
    {
        $banks = BloodBank::all();
        return response()->json($banks);
    }
}
