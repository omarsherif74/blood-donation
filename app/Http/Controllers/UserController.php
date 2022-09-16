<?php

namespace App\Http\Controllers;

use App\Models\BloodBank;
use App\Models\BloodHistory;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use BloodBankTrait;

    public function index()
    {
        $this->createBloodBanks();
//        BloodBank::create(['type' => 'A+',
//            'amount' => 0,]);
//        BloodBank::create(['type' => 'A-',
//            'amount' => 0,]);
//        BloodBank::create(['type' => 'B+',
//            'amount' => 0,]);
//        BloodBank::create(['type' => 'B-',
//            'amount' => 0,]);
//        BloodBank::create(['type' => 'AB+',
//            'amount' => 0,]);
//        BloodBank::create(['type' => 'AB-',
//            'amount' => 0,]);
//        BloodBank::create(['type' => 'O+',
//            'amount' => 0,]);
//        BloodBank::create(['type' => 'O-',
//            'amount' => 0,]);
        return 'blood bank types created';
    }

    public function signup(Request $request)
    {
        $user = new User();
        $user->user_id = $request->user_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->blood_type = $request->blood_type;
        $user->age = $request->age;
        $user->gender = $request->gender;

        $user->save();
        return response()->json(['message' => 'User registration successful', 'code' => 200]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if ($user && $request->password == $user->password) {
            return response()->json(['message' => 'login successful', 'code' => 200]);
        } else {
            return response()->json(['message' => 'wrong login details', 'code' => 501]);
        }
    }

    public function request(Request $request, $user_id)
    {
        $receiver = new BloodHistory();
        $receiver->user_id = $user_id;
        $receiver->blood_type = 'r' . $request->blood_type;

        $receiver->date = $request->date;
        $receiver->save();

        $bank = BloodBank::where('type', $request->blood_type)->first();
        $bank->amount = $bank->amount - 1;
        $bank->save();

        return response()->json(['message' => 'User #' . $user_id . ' requested blood successfully', 'code' => 200]);
    }

    public function donate(Request $request, $user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        if (!$user) {
            return response()->json(['message' => 'User ID not found.', 'code' => 404]);
        } else {
            $donation = new BloodHistory();
            $donation->user_id = $user_id;
//        $temp = substr($request->blood_type, 1);
            $donation->blood_type = 'd' . $user->blood_type;
            $donation->date = $request->date;
            $donation->save();

            $bank = BloodBank::where('type', $user->blood_type)->first();
            $bank->amount = $bank->amount + 1;
            $bank->save();
            return response()->json(['message' => 'User #' . $user_id . ' donated blood successfully', 'code' => 200]);
        }
    }

    public function show_history($user_id)
    {
        $history = BloodHistory::where('user_id', $user_id)->get();
        if (!$history) {
            return response()->json(['message' => 'User ID not found.', 'code' => 404]);
        } else {
            return response()->json($history);
        }
    }


}
