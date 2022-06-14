<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function create(Request $data)
    {
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'type'=>'sdp',
            'password' => Hash::make($data['password']),
        ]);
        return redirect()->route('home');
    }


}
