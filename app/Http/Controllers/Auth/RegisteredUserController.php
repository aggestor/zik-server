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
            'username' => ['required', 'string', 'max:255','unique:'.User::class],
            'firstname' => ['required','string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
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

    public function update(Request $request){

      try {

        $user = User::find($id);
        $user->username = $request->username;
        $user->email = $request->email;
        //$user->password = Hash::make($request->password);
        $user->lastname = $request->lastname;
        $user->postname = $request->postname;
        $user->firstname = $request->firstname;
        $user->phone = $request->phone;
        $user->birthPlace = $request->birthPlace;
        $user->birthDate = $request->birthDate;
        $user->province = $request->province;
        $user->city = $request->city;
        // $user->image = $request->image;
        $user->socialMedia = $request->socialMedia;
        $user->description = $request->description;
        $user->save();

        return ['type'=>'success',"message"=>"Modification reussi "];

      } catch (\Throwable $th) {
        //throw $th;
        return ['type'=>'error',"message"=>"Echec de modification",'errorMessage'=>$th];

      }
    }

    public function savePhoto(Request $request){

        if($request->image){

            $filename = $request->nom .'.'.$request->image->extension();
            $path = $request->image->storeAs('LogoCategorie',$filename,'public');
            $categorie->image = $path;
            return ['type'=>'success','message'=>'Enregistrement reussi'];
        }else return ['type'=>'error','message'=>'Veillez choirir une image !'];
    }
}
