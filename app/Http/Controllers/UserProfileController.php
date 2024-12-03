<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the user profiles.
     */
    public function index()
    {
        return response()->json(UserProfile::all(), 200);
    }

    /**
     * Store a newly created user profile in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $userProfile = UserProfile::create($validated);

        return response()->json($userProfile, 201);
    }

    /**
     * Display the specified user profile.
     */
    public function show(UserProfile $userProfile)
    {
        return response()->json($userProfile, 200);
    }

    /**
     * Update the specified user profile in storage.
     */
    public function update(Request $request, $id)
    {

        try {
            $userProfile= UserProfile::findorFail($id);
            $userProfile->update($request->all());
            return response()->json($userProfile);
        } catch (\Exception $e) {
            return response()->json("probleme de modification");
        }
    }

    /**
     * Remove the specified user profile from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        $userProfile->delete();

        return response()->json(['message' => 'User profile deleted successfully.'], 200);
    }



    public function userDetails(Request $request)
    {
        // Validate the request to ensure email is provided
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Retrieve the user by email
        $user = \App\Models\User::where('email', $validated['email'])->first();

        // If user exists, retrieve the associated profile
        if ($user) {
            $userProfile = $user->profile; // Using the `hasOne` relationship
            return response()->json([
                'user' => $user,
            ], 200);
        }

        // Return an error response if the user is not found (should not reach here due to validation)
        return response()->json([
            'message' => 'User not found',
        ], 404);
    }

    public function updateUser(Request $request, $id)
    {
        // Find the user by ID
        $user = User::with('profile')->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Validate the input data
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id, 
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

       

        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
      // Check if the profile exists; if not, create a new profile
      if ($user->profile) {
        // Update existing profile details
        $user->profile->update([
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address')
        ]);
    } else {
        // Optionally create a new profile if it doesn't exist
        $user->profile()->create([
            'user_id'=> $user->id,
            'name'=> $user->name,
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address')
        ]);
    }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User profile updated successfully.',
            'user' => $user->load('profile'), 
        ]);
    }

}
