<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
class VendorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Vendor::class, 'vendor');
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
     * Display the specified resource.
     *
     * @param  Vendor $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        $role = $vendor->user->role()->select('name')->first();

        $vendor["role"] = $role;
        return okResponse([
            "data" => array_merge($vendor->user->toArray(), $vendor->toArray())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Vendor $vendor)
    {
        $validatedPerson = $request->validate([
            "first_name" => 'string|min:2|max:15',
            "last_name" => 'string|min:2|max:15',
            "username" => "string|min:2|max:15|unique:users,username",
            'address' => 'string|min:2|max:40',
            'phone_number' => 'regex:/^[0-9]{10,}$/|unique:users,phone_number',
            'password' => 'min:6|confirmed',
            'email' => 'email|unique:users,email',
        ]);

        $vendor->first_name = $validatedPerson['first_name'] ?? $vendor->first_name;
        $vendor->last_name = $validatedPerson['last_name'] ?? $vendor->last_name;
        $vendor->save();

        $vendor->user->address = $validatedPerson['address'] ?? $vendor->user->address;
        $vendor->user->phone_number = $validatedPerson['phone_number'] ?? $vendor->user->phone_number;
        $vendor->user->email = $validatedPerson['email'] ?? $vendor->user->email;
        $vendor->user->password = bcrypt($validatedPerson['password']) ?? $vendor->user->password;
        $vendor->user->save();

        $message = getMessage('edited',["model"=>"Vendor"]);

        return okResponse([
            "message"=>$message,
            "data"=>array_merge($vendor->user->toArray(), $vendor->toArray())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        $message = getMessage("deleted",["model" => "Vendor"]);

        return okResponse([
            "message"=>$message,
        ]);
    }
}
