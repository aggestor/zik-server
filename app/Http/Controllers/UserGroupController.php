<?php

namespace App\Http\Controllers;

use App\Models\UsersGroup;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = UsersGroup::all();
        return response()->json($groups);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'user_id'=>'required',
            'grou_id'=>'required'
        ]);
        try {

            UsersGroup::create([
                'user_id'=>$request->user_id,
                'group_id'=>$request->group_id
            ]);
            return ['type'=>'success',"message"=>'Enregistrement reussi'];
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
            'user_id'=>'required',
            'group_id'=>'required'
        ]);
       try {
        
        $group = UsersGroup::find($id);
        $group->user_id = $request->user_id;
        $group->group_id = $request->group_id;
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
        try {
            UsersGroup::destroy($id);
            return ['type'=>'success','message'=>"Suppression reussie"];
        } catch (\Throwable $th) {
            //throw $th;
            return ['type'=>'error','errorMessage'=>"Echec de suppression",'errorMessage'=>$th];
        }
    }
}
