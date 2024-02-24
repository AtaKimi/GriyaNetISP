<?php

namespace App\Http\Controllers\Agent;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\SalesPackage;

class CustomerTransactionController extends Controller
{
    public function index()
    {
        $customer_transactions = CustomerTransaction::where('agent_id', auth()->user()->agent->id)->with('agent.user', 'media', 'salesPackage', 'customer')->latest()->paginate(10);
        $customers = Customer::where('agent_id', auth()->user()->agent->id)->get();
        $sales_packages = SalesPackage::get();
        return Inertia::render('Agent/CustomerTransaction/Index', compact('customer_transactions', 'sales_packages', 'customers'));
    }

    public function store()
    {
        $validated = request()->validate([
            'customer_id' => 'required|exists:customers,id',
            'sales_package_id' => 'required|exists:sales_packages,id',
            'payment_proof' => 'required|mimes:png,jpg,jpeg|max:1024',
        ]);

        $validated['agent_id'] = auth()->user()->agent->id;

        $customer_transaction = CustomerTransaction::create($validated);

        $customer_transaction->addMediaFromRequest('payment_proof')->toMediaCollection('defaut', 'media');

        return redirect()->back()->with(
            'toast',
            [
                'message' => 'Customer Transaction created',
                'toastType' => 'success'
            ]
        );
    }
}
