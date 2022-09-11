<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return 'User index';
    }

    public function register()
    {
        return 'User register here';
    }

    public function login()
    {
        return 'User login here';
    }

    public function request()
    {
        return 'Request Blood';
    }

    public function donate()
    {
        return 'Donate blood';
    }

    public function show_history()
    {
        return 'Show request and donate history';
    }


}
