<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodBank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $admin = Admin::where('email', '=', $request->email)->first();

        if ($admin && $request->password == $admin->password) {
            return response()->json(['message' => 'login successful', 'code' => 200]);
        } else {
            return response()->json(['message' => 'wrong login details', 'code' => 501]);
        }
    }

    public function signup(Request $request)
    {
        $admin = new Admin();
        $admin->admin_id = $request->admin_id;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = $request->password;
        $admin->save();
        return response()->json(['message' => 'Admin registration successful', 'code' => 200]);
    }

    public function list_users()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function list_banks()
    {
        $banks = BloodBank::all();
        return response()->json($banks);
    }
}
