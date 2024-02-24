<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\CustomerTransaction;
use App\Models\SalesPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashbaordController extends Controller
{
    public function index()
    {
        $agent_total_income = 0;
        $validated_customer_transactions = CustomerTransaction::where('validated', '=', '1')->with('salesPackage')->get();
        foreach ($validated_customer_transactions as $transaction) {
            $agent_total_income = $agent_total_income + $transaction->salesPackage->price;
        }

        $agents = Agent::with([
            'validatedCustomerTransaction',
            'user',
            'customerTransactions'
        ])->latest()->get();

        foreach ($agents as $agent) {
            $agent['total_income'] = 0;
            foreach ($agent->validatedCustomerTransaction as $transaction) {
                $agent['total_income'] = $agent['total_income'] + $transaction->salesPackage->price;
            }
        }
        $agent_total = $agents->count();


        $sales_package_total = SalesPackage::get()->count();
        $customer_transaction_total = CustomerTransaction::get()->count();
        $validated_customer_transaction_total = CustomerTransaction::where('validated', '=', '1')->get()->count();
        $unvalidated_customer_transaction_total = CustomerTransaction::where('validated', '=', '0')->get()->count();



        return Inertia::render('Admin/Dashboard', compact(
            'agent_total',
            'agent_total_income',
            'sales_package_total',
            'customer_transaction_total',
            'validated_customer_transaction_total',
            'unvalidated_customer_transaction_total',

            'agents'
        ));
    }
}
