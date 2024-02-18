<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashbaordController extends Controller
{
    public function index()
    {
        return Inertia::render('Sales/Dashboard');
    }
}