<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        $history = History::find($id);
        if($history){
            return response()->json($history,200);
        }else{
            return response()->json(['message' => 'Not Found'], 404);
        }
    }

    public function createHistory($idClient,$coin,$type){
        $history = new History();
        $history->idClient = $idClient;
        $history->coin = $coin;
        $history->type = $type;
        $history->save();
        return true;
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
}
