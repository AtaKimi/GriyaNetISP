<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SalesPackage;

class SalesPackageController extends Controller
{
    public function index()
    {
        $sales_packages = SalesPackage::with('media')->get();
        return Inertia::render('Admin/SalesPackage/Index', compact('sales_packages'));
    }

    public function store()
    {
        $validated = request()->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png|max:1024',
        ]);

        $sales_package = SalesPackage::create($validated);

        $sales_package->addMediaFromRequest('image')->toMediaCollection('default', 'media');

        return redirect()->back()->with(
            'toast',
            [
                'message' => 'Sales Package created',
                'toastType' => 'success'
            ]
        );
    }

    public function update(SalesPackage $sales_package)
    {
        $validated = request()->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:1024',
        ]);

        $sales_package->update($validated);

        if(request()->hasFile('image')){
            $sales_package->clearMediaCollection('default');
            $sales_package->addMediaFromRequest('image')->toMediaCollection('default', 'media');
        }
        return redirect()->back()->with(
            'toast',
            [
                'message' => 'Sales Package updated',
                'toastType' => 'success'
            ]
        );
    }

    public function destroy(SalesPackage $sales_package)
    {
        $sales_package->delete();
        return redirect()->back()->with(
            'toast',
            [
                'message' => 'Sales Package deleted',
                'toastType' => 'success'
            ]
        );
    }
}
