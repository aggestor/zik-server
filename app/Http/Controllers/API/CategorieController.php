<?php

namespace App\Http\Controllers\API;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $logoPath='';

        $request->validate([
            'nom'=>'required|string|max:100',
            'description'=>'required|string|max:255'
        ]);


        try {
            if($request->logo){
                $filename = $request->nom .'.'.$request->logo->extension();
                $logoPath = $request->logo->storeAs('LogoCategorie',$filename,'public');
            }
            Categorie::create([
                'nom'=>$request->nom,
                'description'=>$request->description,
                'logo'=>$logoPath
            ]);

            return ['type'=>'success','message'=>'Enregistrement reussi'];

        } catch (\Throwable $th) {
            return ['type'=>'error','message'=>"Echec d'enregistrement",'errorMessage'=>$th];
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $categorie = Categorie::findOrFail($id);
            return response()->json($categorie);

        } catch (\Throwable $th) {

           return "Cette gategorie n'existe pas";

        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'string|max:255'
        ]);

        try {
            
            $categorie = Categorie::find($id);
            
            if($request->logo){
                $filename = $request->nom .'.'.$request->logo->extension();
                $path = $request->logo->storeAs('LogoCategorie',$filename,'public');
                $categorie->logo = $path;
            }

            $categorie->nom = $request->nom;
            $categorie->description = $request->description;
            $categorie->save();

            return ['type'=>'success','message'=>'Modification reussie'];

        } catch (\Throwable $th) {
           
            return ['type'=>'error','message'=>"Echec de modification","errorMessage"=>$th];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            
            $cat = Categorie::where('id',$id)->get();

            if (count($cat) > 0) {

                if($cat[0]->logo){
                    Storage::delete($cat->logo);
                }
                Categorie::destroy($id);
                return ['type'=>'success','message'=>'Suppression reussie'];
            }else{
                return ['type'=>'error','message'=>"Echec de suppression",'errorMessage'=>$th]; 
            }

        } catch (\Throwable $th) {
            //throw $th;
            return ['type'=>'error','message'=>"Echec de suppression " ,"exception_message"=>$th];
        }
    }
}
