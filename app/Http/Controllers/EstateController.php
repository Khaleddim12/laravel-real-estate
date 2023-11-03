<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Http\Requests\Estate\StoreEstateRequest;
use App\Http\Requests\Estate\UpdateEstateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EstateController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Vendor::class, 'estate');
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEstateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEstateRequest $request)
    {
        $attributes = $request->validated();
        $user = Auth::user();

        $estate = new Estate();
        $estate->address = $attributes['address'];
        $estate->price = $attributes['price'];
        $estate->available = $attributes['available'];

        $image = $request->file('estate_image');


        $estate->estate_image =uploadsUrl().'/'.
        $request->file('estate_image')->store('/estates', ["disk" => 'public']);

        $estate->user_id = $user->id;

        $estate->save();

        $message = getMessage('created',["model" => "Estate"]);

        return okResponse([
            "message" => $message,
            "data" => $estate
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function show(Estate $estate)
    {
        $estate->with('user');

        return okResponse([
            "data" => $estate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEstateRequest  $request
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEstateRequest $request, Estate $estate)
    {
        $attributes = $request->validated();
        $estate->address = $attributes['address'] ?? $estate->address;
        $estate->price = $attributes['price'] ?? $estate->price;
        $estate->available = $attributes['available'] ?? $estate->available;

        if($request->file('estate_image'))
        {
            $path = str_replace(uploadsUrl(), "", $estate->estate_image);
            if(Storage::disk('public')->exists($path))
                Storage::disk('public')->delete($path);

            $estate->estate_image = uploadsUrl().'/'.
                $request->file('estate_image')->store('/estates', ["disk" => 'public']);
        }

        $estate->save();

        $message = getMessage("edited", ["model" => "Estate"]);

        return okResponse([
            "message" => $message,
            "data" => $estate
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estate $estate)
    {
        $path = str_replace(uploadsUrl(), "", $estate->estate_image);

        if(Storage::disk('public')->exists($path))
            Storage::disk('public')->delete($path);

        $estate->delete();

        $message = getMessage("deleted", ["model" => "Estate"]);

        return okResponse([
            'message' => $message
        ]);
    }
}
