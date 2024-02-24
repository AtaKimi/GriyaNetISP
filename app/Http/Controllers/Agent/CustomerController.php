<?php

namespace App\Http\Controllers\Agent;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|min:8',
            'identity_card' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'house_picture' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $validated['agent_id'] = auth()->user()->agent->id;

        $customer = Customer::create($validated);

        $customer->addMediaFromRequest('identity_card')->toMediaCollection('identity_card', 'media');
        $customer->addMediaFromRequest('house_picture')->toMediaCollection('house_picture', 'media');

        return redirect()->back()->with([
            'toast' => [
                'message' => 'Customer created successfully',
                'type' => 'success'
            ]
        ]);
    }

    public function update(Customer $customer)
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|min:8',
            'identity_card' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'house_picture' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $validated['agent_id'] = auth()->user()->agent->id;


        $customer->update($validated);

        if (request()->hasFile('identity_card')) {
            $customer->clearMediaCollection('identity_card');
            $customer->addMediaFromRequest('identity_card')->toMediaCollection('identity_card', 'media');
        }
        if (request()->hasFile('house_picture')) {
            $customer->clearMediaCollection('house_picture');
            $customer->addMediaFromRequest('house_picture')->toMediaCollection('house_picture', 'media');
        }
        return redirect()->back()->with([
            'toast' => [
                'message' => 'Customer updated successfully',
                'type' => 'success'
            ]
        ]);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->back()->with([
            'toast' => [
                'message' => 'Customer deleted successfully',
                'type' => 'success'
            ]
        ]);
    }
}
