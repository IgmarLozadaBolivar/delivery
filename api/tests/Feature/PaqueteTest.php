<?php

namespace Tests\Feature;

use App\Models\Camionero;
use App\Models\EstadoPaquete;
use App\Models\User;
use App\Models\Paquete;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PaqueteTest extends TestCase
{
    protected string $uri = "/api/paquetes";

    // <editor-fold desc="Tests of GET ALL">

    // Case User Admin
    public function test_admin_can_get_paquetes(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(200);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_paquetes(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(200);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_get_paquetes(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_get_paquetes(): void
    {
        $response = $this->getJson("$this->uri");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of GET BY ID">

    // Case User Admin 1
    public function test_admin_can_get_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::firstOrFail();

        $response = $this->getJson("$this->uri/$paquete->id");

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_get_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri/1000");

        $response->assertStatus(404);
    }

    // Case User Camionero 1
    public function test_camionero_can_get_own_paquete(): void
    {
        $camionero = User::factory()->create();
        $camionero->assignRole('camionero');

        $camioneroModel = Camionero::factory()->create([
            'user_id' => $camionero->id,
        ]);

        // Paquete propio
        $paquete = Paquete::factory()->create([
            'camionero_id' => $camioneroModel->id,
        ]);

        Sanctum::actingAs($camionero);

        $response = $this->getJson("/api/paquetes/{$paquete->id}");

        $response->assertStatus(200);
    }

    // Case User Camionero 2
    public function test_camionero_cannot_get_paquete_of_other_camionero(): void
    {
        $camionero = User::factory()->create();
        $camionero->assignRole('camionero');

        Camionero::factory()->create([
            'user_id' => $camionero->id,
        ]);

        // Paquete de otro camionero
        $otroCamionero = Camionero::factory()->create();
        $paquete = Paquete::factory()->create([
            'camionero_id' => $otroCamionero->id,
        ]);

        Sanctum::actingAs($camionero);

        $response = $this->getJson("/api/paquetes/{$paquete->id}");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_get_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $paquete = Paquete::firstOrFail();

        $response = $this->getJson("$this->uri/$paquete->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_get_paquete(): void
    {
        $paquete = Paquete::firstOrFail();

        $response = $this->getJson("$this->uri/$paquete->id");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of POST">

    // Case User Admin 1
    public function test_admin_can_create_paquete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(201);
    }

    // Case User Admin 2
    public function test_admin_can_create_paquete_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Camionero
    public function test_camionero_cannot_create_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_create_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_create_paquete(): void
    {
        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->postJson("$this->uri", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PUT">

    // Case User Admin 1
    public function test_admin_can_put_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::firstOrFail();
        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$paquete->id", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_put_paquete_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::firstOrFail();
        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$paquete->id", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_put_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::firstOrFail();
        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/1000", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_put_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $paquete = Paquete::firstOrFail();
        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$paquete->id", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_put_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $paquete = Paquete::firstOrFail();
        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$paquete->id", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_put_paquete(): void
    {
        $paquete = Paquete::firstOrFail();
        $camionero = Camionero::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->putJson("$this->uri/$paquete->id", [
            "camionero_id" => $camionero->id,
            "estado_id" => $estado->id,
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PATCH">

    // Case User Admin 1
    public function test_admin_can_patch_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$paquete->id", [
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_patch_paquete_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$paquete->id", [
            "direccion" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_patch_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->patchJson("$this->uri/1000", [
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero 1
    public function test_camionero_can_patch_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $paquete = Paquete::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$paquete->id", [
            "estado_id" => $estado->id
        ]);

        $response->assertStatus(200);
    }

    // Case User Camionero 2
    public function test_camionero_can_patch_paquete_info_not_authorized(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $paquete = Paquete::firstOrFail();
        $estado = EstadoPaquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$paquete->id", [
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(422);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_patch_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $paquete = Paquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$paquete->id", [
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_patch_paquete(): void
    {
        $paquete = Paquete::firstOrFail();

        $response = $this->patchJson("$this->uri/$paquete->id", [
            "direccion" => fake()->address()
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of DELETE">

    // Case User Admin 1
    public function test_admin_can_delete_paquete_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $paquete = Paquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$paquete->id");

        $response->assertStatus(200);
        $this->assertSoftDeleted('paquetes', [
            "id" => $paquete->id
        ]);
    }

    // Case User Admin 2
    public function test_admin_can_delete_paquete_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->deleteJson("$this->uri/1000");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_delete_paquete(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $paquete = Paquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$paquete->id");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_delete_paquete(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $paquete = Paquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$paquete->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_delete_paquete(): void
    {
        $paquete = Paquete::firstOrFail();

        $response = $this->deleteJson("$this->uri/$paquete->id");

        $response->assertStatus(401);
    }

    // </editor-fold>
}
