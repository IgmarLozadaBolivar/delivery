<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoPaqueteRequest;
use App\Http\Resources\EstadoPaqueteResource;
use App\Models\EstadoPaquete;

class EstadoPaqueteController extends Controller
{
    public function index()
    {
        return EstadoPaqueteResource::collection(EstadoPaquete::all());
    }

    public function store(EstadoPaqueteRequest $request)
    {
        return new EstadoPaqueteResource(EstadoPaquete::create($request->validated()));
    }

    public function show(EstadoPaquete $id)
    {
        return new EstadoPaqueteResource($id);
    }

    public function update(EstadoPaqueteRequest $request, EstadoPaquete $id)
    {
        $id->update($request->validated());
        return new EstadoPaqueteResource($id);
    }

    public function destroy(EstadoPaquete $id)
    {
        $id->delete();
        return response()->json();
    }
}
