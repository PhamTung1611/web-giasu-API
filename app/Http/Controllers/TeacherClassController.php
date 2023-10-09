<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeacherClassResources;
use App\Models\TechearClass;
use Illuminate\Http\Request;

class TeacherClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = TechearClass::all();
        return TeacherClassResources::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = TechearClass::create($request->all());
        return new TeacherClassResources($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $detail = TechearClass::find($id);
        if($detail){
            return new TeacherClassResources($detail);
        }else{
            return response()->json(['message' => 'Error'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = TechearClass::find($id);
        if($data){
            $data->update($request->all());
        }else{
            return response()->json(['message' => 'Error'], 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = TechearClass::find($id);
        if($data){
            $data->delete();
            return response()->json(['message' => 'Success'], 200);
        }else{
            return response()->json(['message' => 'Error'], 404);

        }
    }
}
