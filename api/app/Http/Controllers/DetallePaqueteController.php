<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetallePaqueteRequest;
use App\Http\Resources\DetallePaqueteResource;
use App\Models\DetallePaquete;
use App\Models\Paquete;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class DetallePaqueteController extends Controller
{
    use AuthorizesRequests;

    public function index(Paquete $paquete)
    {
        $user = auth()->user();

        if ($user->hasRole('admin'))
        {
            $detallePaquete = DetallePaquete::with(['paquete', 'tipoMercancia'])->get();
        } elseif ($user->hasRole('camionero')) {
            $detallePaquete = DetallePaquete::with(['paquete', 'tipoMercancia'])
                ->whereHas('paquete', function ($query) use ($user) {
                    $query->where('camionero_id', $user->camionero->id);
                })
                ->get();
        } else {
            return api_unauthorized('No estás autorizado para esta acción');
        }

        return api_success(DetallePaqueteResource::collection($detallePaquete));
    }

    public function store(DetallePaqueteRequest $request)
    {
        $response = Gate::inspect('create', DetallePaquete::class);

        if (!$response->allowed())
        {
            return api_unauthorized($response->message() ?: "No estás autorizado para esta acción", 403);
        }

        $detallePaquete = new DetallePaqueteResource(DetallePaquete::create($request->validated()));

        return api_success($detallePaquete, "Paquete creado exitosamente", 201);
    }

    public function show(DetallePaquete $detallePaquete)
    {
        //$detallePaquete->load('paquete');
        $response = Gate::inspect('view', $detallePaquete);
        $detallePaquete->load(['paquete', 'tipoMercancia']);

        if (!$response->allowed())
        {
            return api_unauthorized($response->message() ?: "No puedes acceder a un recurso ajeno", 403);
        }

        $detallaPaqueteData = new DetallePaqueteResource($detallePaquete);

        return api_success($detallaPaqueteData, "Se ha encontrado los detalles del paquete solicitante");
    }

    public function update(DetallePaqueteRequest $request, DetallePaquete $detallePaquete)
    {
        $response = Gate::inspect('update', $detallePaquete);

        if (!$response->allowed())
        {
            return api_unauthorized($response->message() ?: "No estás autorizado para esta acción", 403);
        }

        $detallePaquete->update($request->validated());
        $detallePaqueteData = new DetallePaqueteResource($detallePaquete);
        $detallePaquete->load(['paquete', 'tipoMercancia']);

        return api_success($detallePaqueteData, "Se ha actualizado el paquete exitosamente");
    }

    public function destroy(DetallePaquete $detallePaquete)
    {
        $response = Gate::inspect('delete', $detallePaquete);

        if (!$response->allowed())
        {
            return api_unauthorized($response->message() ?: "No estás autorizado para esta acción", 403);
        }

        $detallePaquete->delete();
        return api_success(null, "Se ha eliminado el paquete exitosamente");
    }
}
