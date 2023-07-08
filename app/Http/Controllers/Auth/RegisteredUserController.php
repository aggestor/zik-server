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
            //le password n'a pas de confirmed il est entree comme texte simple
            'password' => ['required', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:255', 'unique:'.User::class],
        ]);

        $user = User::create([
            'email' => $request->email,
            //champs username n'existe pas 
            // 'username' => $request->username,
            'password' => Hash::make($request->password),


            'lastname' => $request->lastname,
            'postname' => $request->postname,
            'firstname' => $request->name,
            //souvenez-vous qu'on a juste mis un seul champ name et les 3 seront a l'update
            // 'firstname' => $request->firstname,
            'phone' => $request->phone,
            'birthPlace' => $request->birthPlace,
            'birthDate' => $request->birthDate,
            'province' => $request->province,
            'city' => $request->city,
            //ces trois champs sont dans la partie suivant donc ils peuvent tous etre null
            'image' => $request->image,
            'socialMedia' => $request->socialMedia,
            'description' => $request->description,
        ]);

        event(new Registered($user));

        Auth::login($user);
        //creation success should return 201 status
        // return response()->noContent();
        return response()->status(201);
    }
}
