<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VendorRegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorRegisterController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRegisterRequest $request)
    {
        $attributes = $request->validated();
        $role = Role::where("name", "Vendor")->first();

        $user = new User();
        $user->username = $attributes['username'];
        $user->phone_number = $attributes['phone_number'];
        $user->email = $attributes['email'];
        $user->address = $attributes['address'];
        $user->password = bcrypt($attributes['password']);
        $user->type = 'vendor';
        $user->role_id = $role->id;

        $user->save();


        $vendor = new Vendor();

        $vendor->first_name = $attributes['first_name'];
        $vendor->last_name = $attributes['last_name'];
        $vendor->user_id = $user->id;

        $user->vendor()->save($vendor);

        $message = getMessage("registered", ["model" => "Vendor"]);
        return okResponse([
            "message"=>$message,
            "data"=>array_merge($vendor->user->toArray(), $vendor->toArray())
        ]);
    }
}
