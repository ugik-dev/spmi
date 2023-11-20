<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Fakultas;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }
}
