<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Models\Character;
use Auth;
class CharacterController extends Controller
{
    public function index(): View
    {
        $characters = Auth::user()->characters()->with('characterClass')->get();

        return view('profile.index', compact('characters'));
    }
}
