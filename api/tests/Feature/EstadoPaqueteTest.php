<?php

namespace Tests\Feature;

use App\Models\User;
use App\MOdels\EstadoPaquete;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EstadoPaqueteTest extends TestCase
{
    protected string $uri = "/api/estados_paquetes";

    // <editor-fold desc="Tests of GET ALL">

    // Case User Admin
    public function test_admin_can_get_estados_paquetes(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(200);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_estados_paquetes(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(403);
    }

    // Case User Not Authorized
    public function test_user_without_role_cannot_get_estados_paquetes(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(403);
    }

    // Case User Not Authenticated
    public function test_user_not_authenticated_cannot_get_estados_paquetes(): void
    {
        $response = $this->getJson("$this->uri");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of GET BY ID">

    // Case User Admin 1
    public function test_admin_can_get_estado_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->getJson("$this->uri/$estado->id");

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_get_estado_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri/200");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_estado_paquete_specified(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->getJson("$this->uri/$estado->id");

        $response->assertStatus(403);
    }

    // Case User Not Authorized
    public function test_user_without_role_cannot_get_estado_paquete_specified(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->getJson("$this->uri/$estado->id");

        $response->assertStatus(403);
    }

    // Case User Not Authenticated
    public function test_user_not_authenticated_cannot_get_estado_paquete_specified(): void
    {
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->getJson("$this->uri/$estado->id");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of POST">

    // Case User Admin 1
    public function test_admin_can_create_estado_paquete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->postJson("$this->uri", [
            "estado" => "Perdido"
        ]);

        $response->assertStatus(201);
    }

    // Case User Admin 2
    public function test_admin_can_create_estado_paquete_with_incorrect(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->postJson("$this->uri", [
            "estado" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Camionero
    public function test_camionero_cannot_create_estado_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->postJson("$this->uri", [
            "estado" => "Perdido"
        ]);

        $response->assertStatus(403);
    }

    // Case User Not Authorized
    public function test_user_without_role_cannot_create_estado_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson("$this->uri", [
            "estado" => "Perdido"
        ]);

        $response->assertStatus(403);
    }

    // Case User Not Authenticated
    public function test_user_guest_cannot_create_estado_paquete(): void
    {
        $response = $this->postJson("$this->uri", [
            "estado" => "Perdido"
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PUT">

    // Case User Admin 1
    public function test_admin_can_update_estado_paquete_by_existing_id(): void
    {
        $admin = User::role("admin")->firstOrFail();

        Sanctum::actingAs($admin);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$estado->id", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_update_estado_paquete_with_info_incomplete(): void
    {
        $admin = User::role("admin")->firstOrFail();

        Sanctum::actingAs($admin);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$estado->id", [
            "estado" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_update_estado_paquete_by_non_existing_id(): void
    {
        $admin = User::role("admin")->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->putJson("$this->uri/200", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_update_estado_paquete(): void
    {
        $camionero = User::role("camionero")->firstOrFail();

        Sanctum::actingAs($camionero);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$estado->id", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_update_estado_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$estado->id", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_update_estado_paquete(): void
    {
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$estado->id", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PATCH">

    // Case User Admin 1
    public function test_admin_can_patch_estado_paquete_by_existing_id(): void
    {
        $admin = User::role("admin")->firstOrFail();

        Sanctum::actingAs($admin);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$estado->id", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_patch_estado_paquete_info_incomplete(): void
    {
        $admin = User::role("admin")->firstOrFail();

        Sanctum::actingAs($admin);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$estado->id", [
            "estado" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_patch_estado_paquete_by_non_existing_id(): void
    {
        $admin = User::role("admin")->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->patchJson("$this->uri/200", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_patch_estado_paquete(): void
    {
        $camionero = User::role("camionero")->firstOrFail();

        Sanctum::actingAs($camionero);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$estado->id", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_patch_estado_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$estado->id", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_patch_estado_paquete():void
    {
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$estado->id", [
            "estado" => "Extraviado"
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of DELETE">

    // Case User Admin 1
    public function test_admin_can_delete_estado_paquete_by_existing_id(): void
    {
        $admin = User::role("admin")->firstOrFail();

        Sanctum::actingAs($admin);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$estado->id");

        $response->assertStatus(200);
        $this->assertSoftDeleted('estados_paquetes', [
            "id" => $estado->id
        ]);
    }

    // Case User Admin 2
    public function test_admin_can_delete_estado_paquete_by_non_existing_id(): void
    {
        $admin = User::role("admin")->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->deleteJson("$this->uri/200");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_delete_estado_paquete(): void
    {
        $user = User::role("camionero")->firstOrFail();

        Sanctum::actingAs($user);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$estado->id");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_delete_estado_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $estado = EstadoPaquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$estado->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_delete_estado_paquete(): void
    {
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$estado->id");

        $response->assertStatus(401);
    }

    // </editor-fold>
}
