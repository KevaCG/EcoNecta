<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Avatar por inicial
        $initial = strtoupper(substr($user->name, 0, 1));
        $avatarUrl = "https://ui-avatars.com/api/?name={$initial}&background=random&color=fff";

        // Historial de recolecciones
        $history = $user->collections()
                        ->orderBy('scheduled_date', 'desc')
                        ->get();

        return view('dashboard.user-dashboard', compact('user', 'avatarUrl', 'history'));
    }
}
