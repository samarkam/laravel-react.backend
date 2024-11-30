<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $userProfiles = UserProfile::all();
            
            // Retourner la réponse JSON avec les profils d'utilisateur
            return response()->json($userProfiles, 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner un message d'erreur
            return response()->json(['message' => "Sélection impossible : {$e->getMessage()}"], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        // Validation des données envoyées dans la requête
        $validatedData = $request->validate([
            'userId' => 'required|exists:users,id',   
            'address' => 'required|string|max:255',    
            'name' => 'required|string|max:255',      
            'phone_number' => 'required|string|max:20',
        ]);

        // Créer un nouveau profil utilisateur avec les données validées
        $userProfile = UserProfile::create([
            'userId' => $validatedData['userId'],
            'address' => $validatedData['address'],
            'name' => $validatedData['name'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        
        return response()->json(['message' => 'Profil utilisateur créé avec succès.', 'data' => $userProfile], 201);
    } catch (\Exception $e) {
        // En cas d'erreur, retourner un message d'erreur
        return response()->json(['message' => "Échec de la création du profil : {$e->getMessage()}"], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(UserProfile $userProfile)
{
    try {
        // Retourner la réponse JSON avec les données du profil utilisateur
        return response()->json($userProfile, 200);
    } catch (\Exception $e) {
        // En cas d'erreur, retourner un message d'erreur
        return response()->json(['message' => "Profil utilisateur introuvable : {$e->getMessage()}"], 404);
    }
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
           
            $article = Article::findOrFail($id);
            $article->update($request->all());
            return response()->json($article);

        } catch (\Exception $e) {

            return response()->json("Problème de modification: {$e->getMessage()}");
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    
    $userProfile = UserProfile::find($id);

    
    if ($userProfile) {
        
        $userProfile->delete();

        return redirect()->route('user.profile.index')->with('success', 'Profil supprimé avec succès!');
    }

    
    return redirect()->route('user.profile.index')->with('error', 'Profil introuvable!');
}

}
