<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $menus = Menu::with(['categories.articles'])->get();
            return response()->json($menus);
        }catch(\exception $e){
            return response()->json("Erreur de recuperation des menus","$e");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $menu= new Menu([
                'name' => $request->input('name'),
                'description' => $request->input('description'),            
            ]);
            $menu ->save();
            return response()->json($menu);
        }catch(\exception $e){
            return response()->json("Erreur menus","$e");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        try{
            $menu= Menu::findOrFail($id);
            return response()->json($menu);
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
            $menu= Menu::findorFail($id);
            $menu->update($request->all());
            return response()->json($menu);
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

            $menu= Menu::findOrFail($id);
        
            $menu ->delete();
            return response()->json("successfully deleted");
        }catch(\exception $e){
            return response()->json("Erreur menus","$e");
        }
    }
}
