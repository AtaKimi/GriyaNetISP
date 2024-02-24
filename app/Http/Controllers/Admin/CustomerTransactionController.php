<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerTransaction;
use Inertia\Inertia;

class CustomerTransactionController extends Controller
{
    public function index()
    {
        $customer_transactions = CustomerTransaction::with(['agent.user', 'salesPackage', 'customer', 'media'])->latest()->paginate(10);
        return Inertia::render('Admin/CustomerTransaction/Index', compact('customer_transactions'));
    }

    public function destroy(CustomerTransaction $customer_transaction)
    {
        $customer_transaction->delete();
        return redirect()->back()->with([
            'toast' => [
                'message' => 'Customer Transaction Deleted!',
                'type' => 'success',
            ]
        ]);    }

    public function updateValidation(CustomerTransaction $customer_transaction)
    {
        $customer_transaction->update([
            'validated' => !$customer_transaction->validated
        ]);


        return redirect()->back()->with([
            'toast' => [
                'message' => 'Customer Transaction Updated',
                'type' => 'success',
            ]
        ]);
    }
}
