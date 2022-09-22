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

        return 'User index';
    }

    public function signup(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->blood_type = $request->bloodType;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->save();
        return response()->json(['message' => "You have signed up successfully"]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if ($user && $request->password == $user->password) {

            return response()->json(['userID' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
                'bloodType' => $user->blood_type,
                'age' => $user->age,
                'gender' => $user->gender,]);

        }
        return response()->json(['message' => 'Login failed']);

    }

    public function request(Request $request, $user_id)
    {
        $user = User::where('user_id', $user_id)->first();

        $bank = BloodBank::where('type', $request->blood_type)->first();
        if (!$user || !$bank || ($bank->amount < $request->amount)) {
            return response()->json(['message' => 'Request failed']);
        }

        $bank->amount = $bank->amount - $request->amount;
        $bank->save();

        $receiver = new BloodHistory();
        $receiver->name = $request->name;

        $patient = User::where('name', $receiver->name)->first();


        $receiver->user_id = $patient->user_id;
        $receiver->blood_type = 'r' . $request->blood_type;
        $receiver->date = $request->date;
        $receiver->amount = $request->amount;
        $receiver->save();

        return response()->json(['message' => 'Requested blood successfully']);

    }

    public function donate(Request $request, $user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        if (!$user) {
            return response()->json(['message' => 'Donation failed']);
        }

        $donation = new BloodHistory();
        $donation->user_id = $user_id;
        $donation->blood_type = 'd' . $user->blood_type;
        $donation->date = $request->date;
        $donation->name = $user->name;
        $donation->amount = $request->amount;
        $donation->save();

        $bank = BloodBank::where('type', $user->blood_type)->first();
        if (!$bank) {
            BloodBank::create(['type' => $user->blood_type, 'amount' => $donation->amount,]);
        } else {
            $bank->amount = $bank->amount + $donation->amount;
            $bank->save();
        }

        return response()->json(['message' => 'Donated blood successfully']);

    }

    public function show_history($user_id)
    {

        $history = BloodHistory::where('user_id', $user_id)->get();
        if (!$history) {
            return response()->json(['message' => 'Cannot show history']);
        }

        $big = array();

        foreach ($history as $record) {

            $user = User::where('user_id', $user_id)->first();

            $bloodType = substr($record->blood_type, 1);
            $temp = substr($record->blood_type, 0, 1);
            if ($temp == 'd') {
                $transactionType = 'Donation';
            } else {
                $transactionType = 'Reciepent';
            }
            $date = $record->date;
            $client = $user->name;


            $array = array(
                'bloodType' => $bloodType,
                'transactionType' => $transactionType,
                'date' => $date,
                'client' => $client);

            array_push($big, $array);
        }

        return $big;

    }

}
