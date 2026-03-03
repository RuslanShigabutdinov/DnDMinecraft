<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Character\StoreRequest;
use Auth;

Class CharacterController extends Controller {

    public function store(StoreRequest $request) {
        $character = Auth::user()
            ->characters()
            ->create($request->character());

        $pointAllocations = $character
            ->pointAllocations()
            ->createMany($request->pointAllocations());
        return response()->json([
            'character' => $character,
            'message' => 'created',
        ], 201);
    }
}
