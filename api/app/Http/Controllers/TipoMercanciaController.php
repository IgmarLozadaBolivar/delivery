<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoMercanciaRequest;
use App\Http\Resources\TipoMercanciaResource;
use App\Models\TipoMercancia;

class TipoMercanciaController extends Controller
{
    public function index()
    {
        return api_success(TipoMercanciaResource::collection(TipoMercancia::all()));
    }

    public function store(TipoMercanciaRequest $request)
    {
        return new TipoMercanciaResource(TipoMercancia::create($request->validated()));
    }

    public function show(TipoMercancia $id)
    {
        return new TipoMercanciaResource($id);
    }

    public function update(TipoMercanciaRequest $request, TipoMercancia $id)
    {
        $id->update($request->validated());
        return new TipoMercanciaResource($id);
    }

    public function destroy(TipoMercancia $id)
    {
        $id->delete();
        return response()->json();
    }
}
