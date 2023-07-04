<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:255', 'unique:'.User::class],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),


            'lastname' => $request->lastname,
            'postname' => $request->postname,
            'firstname' => $request->firstname,
            'phone' => $request->phone,
            'birthPlace' => $request->birthPlace,
            'birthDate' => $request->birthDate,
            'province' => $request->province,
            'city' => $request->city,
            'image' => $request->image,
            'socialMedia' => $request->socialMedia,
            'description' => $request->description,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
