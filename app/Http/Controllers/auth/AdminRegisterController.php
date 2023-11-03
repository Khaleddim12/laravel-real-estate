<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminRegisterController extends Controller
{
    public function store(Request $request)
    {
        $validatedPerson = $request->validate([
            "first_name" => 'required|string|min:2|max:15',
            "last_name" => 'required|string|min:2|max:15',
            "username" => "required|string|min:2|max:15|unique:users,username",
            'address' => 'required|string|min:2|max:40',
            'phone_number' => 'required|regex:/^[0-9]{10,}$/|unique:users,phone_number',
            'password' => 'required|min:6|confirmed',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = new User();

        $user->username = $request->get('username');
        $user->password = bcrypt($request->get('password'));
        $user->address = $request->get('address');
        $user->phone_number = $request->get('phone_number');
        $user->email = $request->get('email');
        $user->type = 'customer';
        $role =Role::where("name", "Administrator")->first();
        $user->role_id = $role->id;

        $user->save();
        $token = $user->createToken("userLoginToken")->plainTextToken;

        $admin  = new Admin();

        $admin->first_name = $request->get('first_name');
        $admin->last_name = $request->get('last_name');
        $admin->user_id = $user->id;

        $user->admin()->save($admin);

        $message = getMessage("registered", ["model" => "Admin"]);
        return okResponse([
            "message"=>$message,
            "data"=>array_merge($admin->user->toArray(), $admin->toArray())
        ]);

    }
}
