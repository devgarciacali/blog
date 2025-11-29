<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        return view('subscriber.profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        $user = Auth::user();

        if($request->hasFile('photo')) {
            //eliminar foto anterior
            File::delete(public_path('storage/' . $profile->photo));
            //asignar una nueva foto
            $photo = $request['photo']->store('profiles');
        }else{
            $photo = $user -> profile->photo;
        }

        // asignar nombre y correo 
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        // asignar foto de perfil
        $user->profile->photo = $photo;

        // guardar campos de usuario 
        $user->save();
        // guardar campos de perfil
        $user->profile->save();

        return redirect()->route('profile.edir', $user->profile->id);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
