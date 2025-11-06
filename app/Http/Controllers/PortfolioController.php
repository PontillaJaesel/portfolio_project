<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function show(User $user)
    {
        $user->load('skills', 'experience', 'projects', 'education', 'organizations.positions');
        return view('public_resume', ['user' => $user]);
    }
}