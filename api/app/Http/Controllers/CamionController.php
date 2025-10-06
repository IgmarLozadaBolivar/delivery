<?php

namespace App\Http\Controllers;

use App\Http\Requests\CamionRequest;
use App\Http\Resources\CamionResource;
use App\Models\Camion;

class CamionController extends Controller
{
    public function index()
    {
        return CamionResource::collection(Camion::all());
    }

    public function store(CamionRequest $request)
    {
        return new CamionResource(Camion::create($request->validated()));
    }

    public function show(Camion $id)
    {
        return new CamionResource($id);
    }

    public function update(CamionRequest $request, Camion $id)
    {
        $id->update($request->validated());
        return new CamionResource($id);
    }

    public function destroy(Camion $id)
    {
        $id->delete();
        return response()->json();
    }
}
