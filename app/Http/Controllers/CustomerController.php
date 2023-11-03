<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Customer::class, 'customer');
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {


        $role = $customer->user->role()->select('name')->first();

        $customer["role"] = $role;
        return okResponse([
            "data" => array_merge($customer->user->toArray(), $customer->toArray())
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedPerson = $request->validate([
            "first_name" => 'string|min:2|max:15',
            "last_name" => 'string|min:2|max:15',
            "budget" => "nullable|integer", // The "nullable" and "integer" rules combined
            "username" => "string|min:2|max:15|unique:users,username",
            'address' => 'string|min:2|max:40',
            'phone_number' => 'regex:/^[0-9]{10,}$/|unique:users,phone_number',
            'password' => 'min:6|confirmed',
            'email' => 'email|unique:users,email',
        ]);

        $customer->first_name = $validatedPerson['first_name'] ?? $customer->first_name;
        $customer->last_name = $validatedPerson['last_name'] ?? $customer->last_name;
        $customer->budget  =$validatedPerson['budget'] ?? $customer->budget;

        $customer->save();
        $customer->user->address = $validatedPerson['address'] ?? $customer->user->address;
        $customer->user->phone_number = $validatedPerson['phone_number'] ?? $customer->user->phone_number;
        $customer->user->email = $validatedPerson['email'] ?? $customer->user->email;
        $customer->user->save();

        $message = getMessage('edited',["model"=>"Customer"]);

        return okResponse([
            "message"=>$message,
            "data"=>array_merge($customer->user->toArray(), $customer->toArray())
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        $message = getMessage("deleted",["model" => "Customer"]);

        return okResponse([
            "message"=>$message,
        ]);
    }
}
