<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show account overview
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $recentOrders = $user->orders()->latest()->take(5)->get();

        return view('account.index', compact('user', 'recentOrders'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        return view('account.edit', ['user' => auth()->user()]);
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('account.index')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show change password form
     */
    public function passwordForm()
    {
        return view('account.password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password:web'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        /** @var User $user */
        $user = auth()->user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('account.index')->with('success', 'Password changed successfully!');
    }
}
