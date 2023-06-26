<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $groups = Group::all();
        return response()->json($groups);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'description'=>'required'
        ]);

        try {
            Group::create([
                'description'=>$request->description
            ]);
            return ['type'=>'success','message'=>"Enregistrement reussi"];
        } catch (\Throwable $th) {
            //throw $th;
            return ['type'=>'error','message'=>"Echec d'enregistrement",'errorMessage'=>$th];
        }
    }

 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description'=>'required'
        ]);
       try {
        
        $group = Group::find($id);
        $group->description = $request->description;
        $group->save();
        return ['type'=>'success','message'=>"Modification reussi"];

       } catch (\Throwable $th) {
        //throw $th;
        return ['type'=>'error','message'=>"Echec de modification"];

       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            Group::destroy($id);
            return ['type'=>'success','message'=>"Suppression reussie"];
        } catch (\Throwable $th) {
            //throw $th;
            return ['type'=>'error','errorMessage'=>"Echec de suppression",'errorMessage'=>$th];
        }
    }
}
