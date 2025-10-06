<?php

namespace App\Http\Controllers;

use App\Http\Requests\CamioneroRequest;
use App\Http\Resources\CamioneroResource;
use App\Models\Camionero;

class CamioneroController extends Controller
{
    public function index()
    {
        return CamioneroResource::collection(Camionero::all());
    }

    public function store(CamioneroRequest $request)
    {
        return new CamioneroResource(Camionero::create($request->validated()));
    }

    public function show(Camionero $id)
    {
        return new CamioneroResource($id);
    }

    public function update(CamioneroRequest $request, Camionero $id)
    {
        $id->update($request->validated());
        return new CamioneroResource($id);
    }

    public function destroy(Camionero $id)
    {
        $id->delete();
        return response()->json();
    }
}
