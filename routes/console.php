<?php

use App\Models\Agent;
use App\Models\CustomerTransaction;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Type\Integer;

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
    dd(datePoint('2029-01-01'));
})->purpose('Display an inspiring quote');

function isPrime($number)
{
    if ($number <= 1) {
        return false;
    }

    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            return false;
        }
    }

    return true;
}

function numberOutput(int $input)
{
    if ($input % 10 == 0) {
        print('Zero');
    } else if ($input % 5 == 0) {
        print('Five');
    } else if ($input % 2 == 0) {
        print('Even');
    } else {
        $str_number = strval($input);
        if ($str_number[strlen($str_number) - 1] == '3' || $str_number[strlen($str_number) - 1] == '7') {
            print('Prime');
        } else {
            print('Invalid');
        }
    }
}


function datePoint($date)
{
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return -1;
    }

    $parts = explode('-', $date);
    $year = $parts[0];
    $month = $parts[1];
    $day = $parts[2];

    $totalPoint = 0;
    foreach (str_split($year) as $digit) {
        $totalPoint += (int) $digit;
    }
    foreach (str_split($month) as $digit) {
        $totalPoint += (int) $digit;
    }
    foreach (str_split($day) as $digit) {
        $totalPoint += (int) $digit;
    }

    return $totalPoint;
}
