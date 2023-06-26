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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'postnom' => $request->postnom,
            'prenom' => $request->prenom,
            'tel' => $request->tel,
            'lieuDeNaissance' => $request->lieuDeNaissance,
            'dateDeNaissance' => $request->dateDeNaissance,
            'province' => $request->province,
            'ville' => $request->ville,
            'photo' => $request->photo,
            'reseauxSociaux' => $request->reseauxSociaux,
            'description' => $request->description,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
