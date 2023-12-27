<?php

namespace App\Http\Controllers;

use App\Models\Champion;
use App\Models\Spell;
use Illuminate\Http\Request;

class SpellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spell $spell)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spell $spell)
    {
        //
    }

    public function getSpellsForChampion($championId)
    {
        $champion = Champion::with('spells')->find($championId);

        if (!$champion) {
            return response()->json(['message' => 'Aucun champion correspondant'], 404);
        }

        return response()->json($champion->spells);
    }
}

