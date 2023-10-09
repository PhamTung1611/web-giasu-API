<?php

namespace App\Http\Controllers;

use App\Models\TechearSubject;
use App\Http\Resources\TeacherSubjectResources;

use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = TechearSubject::all();
        return TeacherSubjectResources::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = TechearSubject::create($request->all());
        return new TeacherSubjectResources($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $detail = TechearSubject::find($id);
        if($detail){
            return new TeacherSubjectResources($detail);
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
        $data = TechearSubject::find($id);
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
        $data = TechearSubject::find($id);
        if($data){
            $data->delete();
            return response()->json(['message' => 'Success'], 200);
        }else{
            return response()->json(['message' => 'Error'], 404);

        }
    }
}
