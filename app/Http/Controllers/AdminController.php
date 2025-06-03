<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'books' => Book::count(),
            'loans' => Loan::whereNull('returned_at')->count()
        ];

        return view('admin.dashboard', compact('stats'));
    }
}