<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Estate;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Vendor::class, 'deal');
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
     * @return \Illuminate\Http\Response
     */
    public function store(Estate $estate)
    {
        $user = Auth::user();


        $deal = new Deal();
        $deal->estate_id = $estate->id;
        $deal->user_id = $user->id;
        $deal->done = false;
        $deal->save();

        $message = getMessage('created', ["model" => 'Deal']);

        return okResponse([
            'message' => $message,
            'data' => $deal
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function show(Deal $deal)
    {
        return okResponse([
            'data' => $deal
        ]);
    }

    /**
     * Update the done field in the deal when the deal is done.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function done(Deal $deal)
    {
        error_log(Auth::user()->id);
        error_log($deal->user_id);

        $deal->done = true;
        $deal->save();

        $message = "the deal has been approved";

        return okResponse([
            "message" => $message
        ]);
    }


    /**
     * Update the done field in the deal when the deal is done.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function cancel(Deal $deal)
    {

        $deal->done = false;
        $deal->save();

        $message = "the deal has been cancelled";

        return okResponse([
            "message" => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deal $deal)
    {
        $deal->delete();
        $message = getMessage("deleted", ["model" => "Deal"]);

        return okResponse([
            "message" => $message,
        ]);
    }
}
