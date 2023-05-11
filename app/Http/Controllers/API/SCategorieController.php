<?php

namespace App\Http\Controllers\API;

use App\Models\SCategorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scategories = SCategorie::all();
        return response()->json($scategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $logoPath='';

        $request->validate([
            'nom'=>'required|string|max:100',
            'description'=>'required|string|max:255',
            'categorie_id'=>'required'
        ]);


        try {
            if($request->logo){
                $filename = $request->nom .'.'.$request->logo->extension();
                $logoPath = $request->logo->storeAs('LogoSousCategorie',$filename,'public');
            }
            Categorie::create([
                'nom'=>$request->nom,
                'description'=>$request->description,
                'categorie_id'=>$request->categorie_id,
                'logo'=$logoPath
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

            $categorie SCategorie::findOrFail($id);
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
            'description' => 'string|max:255',
            'categorie_id'=>'required'
        ]);

        try {
            
            $scategorie = SCategorie::find($id);
            
            if($request->logo){
                $filename = $request->nom .'.'.$request->logo->extension();
                $path = $request->logo->storeAs('LogoCategorie',$filename,'public');
                $scategorie->logo = $path;
            }

            $scategorie->nom = $request->nom;
            $scategorie->description = $request->description;
            $scategorie->categorie_id = $request->categorie_id;
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
            
            $scat = Categorie::where('id',$id)->get();

            if (count($scat) > 0) {

                if($scat[0]->logo){
                    Storage::delete($scat->logo);
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
