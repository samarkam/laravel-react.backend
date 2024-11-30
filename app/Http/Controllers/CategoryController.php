<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $categories= Category::all();
            return response()->json($categories);
        }catch(\exception $e){
            return response()->json("Erreur de recuperation des categories","$e");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $categorie= new Category([
                'label' => $request->input('label'),
                'menuID' => $request->input('menuID'),            
            ]);
            $categorie ->save();
            return response()->json($categorie);
        }catch(\exception $e){
            return response()->json("Erreur categories","$e");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        try{
            $categorie= Category::findOrFail($id);
            return response()->json($categorie);
        } catch (\Exception $e) {
            return response()->json("probleme de récupération des données");
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        try {
            $categorie= Category::findorFail($id);
            $categorie->update($request->all());
            return response()->json($categorie);
        } catch (\Exception $e) {
            return response()->json("probleme de modification");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{

            $categorie= Category::findOrFail($id);
        
            $categorie ->delete();
            return response()->json("successfully deleted");
        }catch(\exception $e){
            return response()->json("Erreur categories","$e");
        }
    }
}
