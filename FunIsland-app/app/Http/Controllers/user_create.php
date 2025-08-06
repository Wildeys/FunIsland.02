<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class user_create extends Controller
{
    protected function create(array $data)
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role_id' => Role::where('name', 'customer')->first()->id,
    ]);
}
}
