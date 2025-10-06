<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaqueteRequest;
use App\Http\Resources\PaqueteResource;
use App\Models\Paquete;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class PaqueteController extends Controller
{
    use AuthorizesRequests;

    public function __construct() {}

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $paquetes = Paquete::with(['camionero', 'estadoPaquete'])->get();
        } elseif ($user->hasRole('camionero')) {
            $paquetes = Paquete::with(['camionero', 'estadoPaquete'])
                ->where('camionero_id', $user->camionero->id)
                ->get();
        } else {
            return api_unauthorized('No estás autorizado para esta acción');
        }

        return api_success(PaqueteResource::collection($paquetes));
    }

    public function store(PaqueteRequest $request)
    {
        $response = Gate::inspect('create', Paquete::class);

        if (!$response->allowed()) {
            return api_unauthorized($response->message() ?: "No estás autorizado para esta acción", 403);
        }

        $paquete = new PaqueteResource(Paquete::create($request->validated()));

        return api_success($paquete, "Paquete creado exitosamente", 201);
    }

    public function show(Paquete $paquete)
    {
        $response = Gate::inspect('view', $paquete);
        $paquete->load(['camionero', 'estadoPaquete']);

        if (!$response->allowed())
        {
            return api_unauthorized($response->message() ?: "No puedes acceder a un recurso ajeno", 403);
        }

        $paqueteData = new PaqueteResource($paquete);

        return api_success($paqueteData, "Se ha encontrado el paquete solicitante");
    }

    public function update(PaqueteRequest $request, Paquete $paquete)
    {
        $user = auth()->user();

        if ($request->isMethod('PUT')) {
            // Solo admin
            if (!$user->hasRole('admin')) {
                return api_unauthorized("No estás autorizado para actualizar con PUT", 403);
            }
        }

        if ($request->isMethod('PATCH')) {
            $response = Gate::inspect('update', $paquete);
            if (!$response->allowed()) {
                return api_unauthorized("No estás autorizado para hacer PATCH", 403);
            }
        }

        $paquete->update($request->validated());
        $paquete->load(['camionero', 'estadoPaquete']);

        return api_success(new PaqueteResource($paquete), "Se ha actualizado el paquete exitosamente");
    }

    public function destroy(Paquete $paquete)
    {
        $response = Gate::inspect('delete', $paquete);

        if (!$response->allowed())
        {
            return api_unauthorized($response->message() ?: "No estás autorizado para esta acción", 403);
        }

        $paquete->delete();
        return api_success(null, "Se ha eliminado el paquete exitosamente");
    }
}
