<?php

namespace Tests\Feature;

use App\Models\DetallePaquete;
use App\Models\Paquete;
use App\Models\TipoMercancia;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DetallePaqueteTest extends TestCase
{
    protected string $uri = "/api/detalles_paquetes";

    // <editor-fold desc="Tests of GET ALL">

    // Case User Admin
    public function test_admin_can_get_detalles_paquetes(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(200);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_detalles_paquetes(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(200);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_get_detalles_paquetes(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_get_detalles_paquetes(): void
    {
        $response = $this->getJson("$this->uri");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of GET BY ID">

    // Case User Admin 1
    public function test_admin_can_get_detalle_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->getJson("$this->uri/$detallePaquete->id");

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_get_detalle_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri/1000");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_detalle_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->getJson("$this->uri/$detallePaquete->id");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_get_detalle_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->getJson("$this->uri/$detallePaquete->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_get_detalle_paquete(): void
    {
        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->getJson("$this->uri/$detallePaquete->id");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of POST">

    // Case User Admin 1
    public function test_admin_can_create_detalle_paquete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => now()
        ]);

        $response->assertStatus(201);
    }

    // Case User Admin 2
    public function test_admin_can_create_detalle_paquete_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Camionero
    public function test_camionero_cannot_create_detalle_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => fake()->date()
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_create_detalle_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => fake()->date()
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_create_detalle_paquete(): void
    {
        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => fake()->date()
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PUT">

    // Case User Admin 1
    public function test_admin_can_put_detalle_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $detallePaquete = DetallePaquete::firstOrFail();
        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("$this->uri/$detallePaquete->id", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => now()
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_put_detalle_paquete_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $detallePaquete = DetallePaquete::firstOrFail();
        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("$this->uri/$detallePaquete->id", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_put_detalle_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("$this->uri/1000", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => fake()->date()
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_put_detalle_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $detallePaquete = DetallePaquete::firstOrFail();
        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("$this->uri/$detallePaquete->id", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => now()
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_put_detalle_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $detallePaquete = DetallePaquete::firstOrFail();
        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("$this->uri/$detallePaquete->id", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => fake()->date()
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_put_detalle_paquete(): void
    {
        $detallePaquete = DetallePaquete::firstOrFail();
        $paquete = Paquete::factory()->create();
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("$this->uri/$detallePaquete->id", [
            "paquete_id" => $paquete->id,
            "tipo_mercancia_id" => $tipo->id,
            "dimension" => fake()->bothify('##x##x##'),
            "peso" => fake()->randomFloat(2, 1, 500),
            "fecha_entrega" => fake()->date()
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PATCH">

    // Case User Admin 1
    public function test_admin_can_patch_detalle_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$detallePaquete->id", [
            "dimension" => fake()->bothify("##x##x##")
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_patch_detalle_paquete_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$detallePaquete->id", [
            "dimension" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_patch_detalle_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->patchJson("$this->uri/1000", [
            "dimension" => fake()->bothify('##x##x##')
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_patch_detalle_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$detallePaquete->id", [
            "dimension" => fake()->bothify('##x##x##')
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_patch_detalle_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$detallePaquete->id", [
            "dimension" => fake()->bothify('##x##x##')
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_patch_detalle_paquete(): void
    {
        $detallePaquete = DetallePaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$detallePaquete->id", [
            "dimension" => fake()->bothify('##x##x##')
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of DELETE">

    // Case User Admin 1
    public function test_admin_can_delete_detalle_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $detalle_paquete = DetallePaquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$detalle_paquete->id");

        $response->assertStatus(200);
        $this->assertSoftDeleted('detalles_paquetes', [
            "id" => $detalle_paquete->id
        ]);
    }

    // Case User Admin 2
    public function test_admin_can_delete_detalle_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->deleteJson("$this->uri/1000");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_delete_detalle_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $detalle_paquete = DetallePaquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$detalle_paquete->id");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_delete_detalle_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $detalle_paquete = DetallePaquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$detalle_paquete->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_delete_detalle_paquete(): void
    {
        $detalle_paquete = DetallePaquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$detalle_paquete->id");

        $response->assertStatus(401);
    }

    // </editor-fold>
}
