<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index()
    {
        // Récupérer les 6 derniers livres ajoutés
        $dernierLivres = Livre::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('accueil', compact('dernierLivres'));
    }
} 