<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\WasteType;

class AuthController extends Controller
{
    // ===========================================
    // Métodos para el flujo de registro por pasos
    // ===========================================

    /**
     * Muestra el paso 1 del formulario (Datos Personales).
     */
    public function showStep1()
    {
        return view('auth.register.step1');
    }

    /**
     * Procesa el paso 1 y redirige al paso 2.
     */
    public function processStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'document_id' => 'required|string|max:20|unique:users',
            'phone_whatsapp' => 'nullable|string|max:20|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Guarda los datos en la sesión
        $request->session()->put('registration.step1', $request->only(['name', 'email', 'password', 'document_id', 'phone_whatsapp']));

        return redirect()->route('register.step2');
    }

    /**
     * Muestra el paso 2 del formulario (Dirección).
     */
    public function showStep2(Request $request)
    {
        // Verifica que el paso 1 esté completo
        if (!$request->session()->has('registration.step1')) {
            return redirect()->route('register');
        }

        return view('auth.register.step2');
    }

    /**
     * Procesa el paso 2 y redirige al paso 3.
     */
    public function processStep2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'locality' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Guarda los datos en la sesión
        $request->session()->put('registration.step2', $request->only(['address', 'neighborhood', 'postal_code', 'locality']));

        return redirect()->route('register.step3');
    }

    /**
     * Muestra el paso 3 del formulario (Tipos de Residuos).
     */
    public function showStep3(Request $request)
    {
        // Verifica que los pasos anteriores estén completos
        if (!$request->session()->has('registration.step1') || !$request->session()->has('registration.step2')) {
            return redirect()->route('register');
        }

        return view('auth.register.step3');
    }

    /**
     * Procesa el paso 3, crea el usuario y finaliza el registro.
     */
    public function processStep3(Request $request)
    {
        // Validar el último paso
        $validator = Validator::make($request->all(), [
            'waste_types' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Fusionar todos los datos de la sesión y el formulario
        $data = array_merge(
            $request->session()->get('registration.step1'),
            $request->session()->get('registration.step2'),
            $request->only(['waste_types'])
        );

        // Crear el usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'document_id' => $data['document_id'],
            'phone_whatsapp' => $data['phone_whatsapp'],
            'address' => $data['address'],
            'neighborhood' => $data['neighborhood'],
            'postal_code' => $data['postal_code'],
            'locality' => $data['locality'],
        ]);

        // Sincronizar los tipos de residuos
        if (isset($data['waste_types'])) {
            $wasteTypeIds = WasteType::whereIn('name', $data['waste_types'])->pluck('id');
            $user->wasteTypes()->sync($wasteTypeIds);
        }

        // Eliminar los datos de la sesión para limpiar
        $request->session()->forget('registration');

        // Iniciar sesión y redirigir
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    // ===========================================
    // Métodos para el inicio y cierre de sesión
    // ===========================================

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa el intento de inicio de sesión.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
