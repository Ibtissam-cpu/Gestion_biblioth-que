<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Récupérer les 6 derniers livres ajoutés
        $latestBooks = Book::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('welcome', compact('latestBooks'));
    }
} 