<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard()
    {
        $loans = auth()->user()->loans()->with('book')->latest()->take(5)->get();
        return view('client.dashboard', compact('loans'));
    }
}