<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\WasteType; // Necesitamos este modelo para sincronizar

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home'; // O la ruta a la que quieras redirigir

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_whatsapp' => ['nullable', 'string', 'max:20', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'locality' => ['required', 'string', 'max:255'],
            'waste_types' => ['required', 'array', 'min:1'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_whatsapp' => $data['phone_whatsapp'] ?? null,
            'address' => $data['address'],
            'neighborhood' => $data['neighborhood'],
            'postal_code' => $data['postal_code'] ?? null,
            'locality_id' => 1, // Por ahora, usaremos un ID ficticio. Lo ajustaremos después.
        ]);

        // Guardar los tipos de residuos en la tabla pivote
        if (isset($data['waste_types'])) {
            $wasteTypes = WasteType::all(); // Aquí asumo que ya tienes un modelo y una tabla para waste_types
            $wasteTypeIds = [];
            foreach ($data['waste_types'] as $wasteName) {
                // Obtener el ID del tipo de residuo por su nombre
                $wasteType = $wasteTypes->firstWhere('name', $wasteName);
                if ($wasteType) {
                    $wasteTypeIds[] = $wasteType->id;
                }
            }
            $user->wasteTypes()->sync($wasteTypeIds);
        }

        return $user;
    }
}
