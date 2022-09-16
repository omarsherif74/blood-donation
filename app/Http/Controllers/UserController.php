<?php

namespace App\Http\Controllers;

use App\Models\BloodBank;
use App\Models\BloodHistory;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {

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

        $user = User::where('user_id', $user_id)->first();
        if (!$user) {
            return response()->json(['message' => 'User ID not found.', 'code' => 404]);
        }


        $bank = BloodBank::where('type', $request->blood_type)->first();
        if (!$bank || $bank->amount <= 0) {
            return response()->json(['message' => 'No available blood banks for user #' . $user_id, 'code' => 404]);
        }
        $bank->amount = $bank->amount - 1;
        $bank->save();

        $receiver = new BloodHistory();
        $receiver->user_id = $user_id;
        $receiver->blood_type = 'r' . $request->blood_type;
        $receiver->date = $request->date;
        $receiver->save();


        return response()->json(['message' => 'User #' . $user_id . ' requested blood successfully', 'code' => 200]);

//        $receiver = new BloodHistory();
//        $receiver->user_id = $user_id;
//        $receiver->blood_type = 'r' . $request->blood_type;
//
//        $receiver->date = $request->date;
//        $receiver->save();
//
//        $bank = BloodBank::where('type', $request->blood_type)->first();
//        $bank->amount = $bank->amount - 1;
//        $bank->save();
//
//        return response()->json(['message' => 'User #' . $user_id . ' requested blood successfully', 'code' => 200]);
    }

    public function donate(Request $request, $user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        if (!$user) {
            return response()->json(['message' => 'User ID not found.', 'code' => 404]);
        }

        $donation = new BloodHistory();
        $donation->user_id = $user_id;
        $donation->blood_type = 'd' . $user->blood_type;
        $donation->date = $request->date;
        $donation->save();

        $bank = BloodBank::where('type', $user->blood_type)->first();
        if (!$bank) {
            BloodBank::create([
                    'type' => $user->blood_type,
                    'amount' => 1,
                ]
            );
        } else {
            $bank->amount = $bank->amount + 1;
            $bank->save();
        }

        return response()->json(['message' => 'User #' . $user_id . ' donated blood successfully', 'code' => 200]);

    }

    public function show_history($user_id)
    {
        $history = BloodHistory::where('user_id', $user_id)->first();
        if (!$history) {
            return response()->json(['message' => 'User ID not found.', 'code' => 404]);
        }
//            return response()->json($history);
        $user = User::where('user_id', $user_id)->first();

        $bloodType = $user->blood_type;
        $temp = substr($user->blood_type, 0, 1);
        if ($temp == 'd') {
            $transactionType = 'Donation';
        } else {
            $transactionType = 'Reciepent';
        }
        $date = $history->date;
        $client = $user->name;

        $array = array(
            'bloodType' => $bloodType,
            'transactionType' => $transactionType,
            'date' => $date,
            'client' => $client,
        );
        return $array;


    }


}
