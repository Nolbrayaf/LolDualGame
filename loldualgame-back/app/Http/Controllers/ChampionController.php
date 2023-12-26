<?php

namespace App\Http\Controllers;

use App\Models\Champion;
use Illuminate\Http\Request;

class ChampionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $championsData = Champion::all();

        return $championsData;
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getUniqueTags()
    {
        $uniqueTags = Champion::all('tags')
                        ->pluck('tags')
                        ->flatMap(function ($tags) {
                            return json_decode($tags, true);
                        })
                        ->unique()
                        ->sort()
                        ->values();

        return response($uniqueTags, 200);
    }

}
