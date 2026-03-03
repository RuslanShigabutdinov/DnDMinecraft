<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterController extends Controller
{
    public function index(): View
    {
        $characters = auth()->user()->characters()->with('characterClass')->get();

        return view('profile.index', compact('characters'));
    }

    public function store(): JsonResponse {

        return response()->json([
            'message' => 'created',
        ], 201);
    }
}
