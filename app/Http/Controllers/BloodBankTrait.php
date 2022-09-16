<?php

namespace App\Http\Controllers;

use App\Models\BloodBank;

trait BloodBankTrait
{
    public function createBloodBanks()
    {
        BloodBank::create(['type' => 'A+',
            'amount' => 0,]);
        BloodBank::create(['type' => 'A-',
            'amount' => 0,]);
        BloodBank::create(['type' => 'B+',
            'amount' => 0,]);
        BloodBank::create(['type' => 'B-',
            'amount' => 0,]);
        BloodBank::create(['type' => 'AB+',
            'amount' => 0,]);
        BloodBank::create(['type' => 'AB-',
            'amount' => 0,]);
        BloodBank::create(['type' => 'O+',
            'amount' => 0,]);
        BloodBank::create(['type' => 'O-',
            'amount' => 0,]);
    }

}
