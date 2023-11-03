<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Vendor::class, 'admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        $role = $admin->user->role()->select('name')->first();

        $admin["role"] = $role;
        return okResponse([
            "data" => array_merge($admin->user->toArray(), $admin->toArray())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $validatedPerson = $request->validate([
            "first_name" => 'string|min:2|max:15',
            "last_name" => 'string|min:2|max:15',
            "username" => "string|min:2|max:15|unique:users,username",
            'address' => 'string|min:2|max:40',
            'phone_number' => 'regex:/^[0-9]{10,}$/|unique:users,phone_number',
            'email' => 'email|unique:users,email',
        ]);

        $admin->first_name = $validatedPerson['first_name'] ?? $admin->first_name;
        $admin->last_name = $validatedPerson['last_name'] ?? $admin->last_name;
        $admin->save();

        $admin->user->address = $validatedPerson['address'] ?? $admin->user->address;
        $admin->user->phone_number = $validatedPerson['phone_number'] ?? $admin->user->phone_number;
        $admin->user->email = $validatedPerson['email'] ?? $admin->user->email;
        $admin->user->save();

        $message = getMessage('edited',["model"=>"Admin"]);

        return okResponse([
            "message"=>$message,
            "data"=>array_merge($admin->user->toArray(), $admin->toArray())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        $message = getMessage("deleted",["model" => "Admin"]);

        return okResponse([
            "message"=>$message,
        ]);
    }
}
