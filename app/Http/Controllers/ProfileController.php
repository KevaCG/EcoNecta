<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\WasteType; // Necesitamos este modelo para sincronizar

class ProfileController extends Controller
{
    /**
     * Muestra el formulario de edición del perfil del usuario.
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()->load('wasteTypes'),
            'allWasteTypes' => WasteType::all(),
        ]);
    }

    

    /**
     * Actualiza la información del perfil del usuario.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Validamos la información personal y la de la dirección
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone_whatsapp' => ['nullable', 'string', 'max:20', Rule::unique(User::class)->ignore($user->id)],
            'address' => ['required', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'locality' => ['required', 'string', 'max:255'],
            'receive_whatsapp' => ['nullable', 'boolean'],
            'waste_types' => ['nullable', 'array'],
        ]);

        $user->fill($validatedData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Guardamos los tipos de residuos
        if ($request->has('waste_types')) {
            $wasteTypeIds = WasteType::whereIn('name', $request->waste_types)->pluck('id');
            $user->wasteTypes()->sync($wasteTypeIds);
        } else {
            // Si no se selecciona ninguno, desvinculamos todos
            $user->wasteTypes()->sync([]);
        }


        // Guardamos los cambios en el modelo de usuario
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
}
