<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $allUtilityFiles = glob(app_path("Utils") . "/*.php");

        foreach ($allUtilityFiles as $key => $utilityFile) {
            require_once $utilityFile;
        }
    }
}
