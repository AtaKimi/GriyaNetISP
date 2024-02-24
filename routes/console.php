<?php

use App\Models\Agent;
use App\Models\CustomerTransaction;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    dd(
        $agent_total_income = CustomerTransaction::where('validated', '=', '1')->with('salesPackage')->get()->first()->sum('salesPackage.price')
    );
})->purpose('Display an inspiring quote');
