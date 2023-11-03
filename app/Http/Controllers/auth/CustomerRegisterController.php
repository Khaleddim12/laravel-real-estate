<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerRegisterController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedPerson = $request->validate([
            "first_name" => 'required|string|min:2|max:15',
            "last_name" => 'required|string|min:2|max:15',
            "budget" => "nullable|integer", // The "nullable" and "integer" rules combined
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
        $role =Role::where("name", "Customer")->first();
        $user->role_id = $role->id;

        $user->save();
        $token = $user->createToken("userLoginToken")->plainTextToken;


        $customer = new Customer();

        $customer->first_name = $request->get('first_name');
        $customer->last_name = $request->get('last_name');
        $customer->budget = $request->get('budget');
        $customer->user_id = $user->id;

        $user->customer()->save($customer);

        $message = getMessage("registered", ["model" => "Customer"]);
        return okResponse([
            "message"=>$message,
            "data"=>array_merge($customer->user->toArray(), $customer->toArray())
        ]);
    }
}
