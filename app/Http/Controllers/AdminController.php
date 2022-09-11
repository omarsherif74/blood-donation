<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function index(){
        return 'Admin index page';
    }

    public function show_users()
    {
        return 'Admin show users';
    }

    public function show_banks()
    {
        return 'Admin show banks';
    }
}
