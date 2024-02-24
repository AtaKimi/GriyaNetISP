<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\SalesPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesPackageController extends Controller
{
    public function index()
    {
        $sales_packages = SalesPackage::with('media')->latest()->paginate(10);
        return Inertia::render('Agent/SalesPackage/Index', compact('sales_packages'));
    }
}
