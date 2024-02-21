<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Agent;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::with('user')->get();
        return Inertia::render('Admin/Agent/Index', compact('agents'));
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email',
            'password' => 'required|confirmed|string|min:8',
            'nip' => 'required|numeric|unique:agents,nip',
        ]);

        $user = User::create($validated);
        $agent_role = Role::where('name', '=', 'agent')->first();
        $user->assignRole($agent_role);

        $agent = $user->agent()->create([
            'nip' => $validated['nip'],
        ]);

        session('toast', 'it');
        return redirect()->back()->with('toast', [
            'message' => 'Agent created',
            'toastType' => 'success'
        ]);
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        $user = $agent->user;

        $user->delete();
        return redirect()->back()->with(
            'toast',
            [
                'message' => 'Agent deleted',
                'toastType' => 'danger'
            ]
        );
    }
}
