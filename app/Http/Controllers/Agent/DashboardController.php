<?php

namespace App\Http\Controllers\Agent;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::with('media')->latest()->paginate(10);
        return Inertia::render('Agent/Dashboard', compact('customers'));
    }
}
