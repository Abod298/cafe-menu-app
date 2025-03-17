<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $slug = \Str::slug($request->name);
        $request->merge(['slug' => $slug]);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:users,slug',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $userRole = Role::where('title', Role::DEFAULT_ROLE)->first();

        if ($userRole) {
            $user->roles()->attach($userRole->id);
        }
        event(new Registered($user));

        return redirect()->route('users.index')->with('success' , 'User Created Successfuly !');
    }
}
