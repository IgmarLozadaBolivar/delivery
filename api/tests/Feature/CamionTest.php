<?php

namespace Tests\Feature;

use App\Models\Camion;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CamionTest extends TestCase
{
    protected string $uri = "/api/camiones";

    // <editor-fold desc="Tests of GET ALL">

    // Case User Admin
    public function test_admin_can_get_camiones(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(200);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_camiones(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_get_camiones(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_get_camiones(): void
    {
        $response = $this->getJson("$this->uri");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of GET BY ID">

    // Case User Admin 1
    public function test_admin_can_get_camion_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camion = Camion::firstOrFail();

        $response = $this->getJson("$this->uri/$camion->id");

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_get_camion_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri/200");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_camion(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camion = Camion::firstOrFail();

        $response = $this->getJson("$this->uri/$camion->id");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_get_camion(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camion = Camion::firstOrFail();

        $response = $this->getJson("$this->uri/$camion->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_get_camion(): void
    {
        $camion = Camion::firstOrFail();

        $response = $this->getJson("$this->uri/$camion->id");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of POST">

    // Case User Admin 1
    public function test_admin_can_create_camion(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->postJson("$this->uri", [
            "marca" => "VOLVO",
            "modelo" => "FH",
            "placa" => fake()->bothify('???###')
        ]);

        $response->assertStatus(201);
    }

    // Case User Admin 2
    public function test_admin_can_create_camion_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->postJson("$this->uri", [
            "marca" => "VOLVO",
            "modelo" => "FH",
            "placa" => "" // Campo vacío, para activar la validación
        ]);

        $response->assertStatus(422);
    }

    // Case User Camionero
    public function test_camionero_cannot_create_camion(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->postJson("$this->uri", [
            "marca" => "VOLVO",
            "modelo" => "FH",
            "placa" => "ABC123"
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_create_camion(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson("$this->uri", [
            "marca" => "VOLVO",
            "modelo" => "FH",
            "placa" => "ABC123"
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_create_camion(): void
    {
        $response = $this->postJson("$this->uri", [
            "marca" => "VOLVO",
            "modelo" => "FH",
            "placa" => "ABC123"
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PUT">

    // Case User Admin 1
    public function test_admin_can_put_camion_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camion = Camion::firstOrFail();

        $response = $this->putJson("$this->uri/$camion->id", [
            "marca" => "VOLVO",
            "modelo" => "FHX",
            "placa" => fake()->bothify('???###')
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_put_camion_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camion = Camion::firstOrFail();

        $response = $this->putJson("$this->uri/$camion->id", [
            "marca" => "VOLVO",
            "modelo" => "FHX",
            "placa" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_put_camion_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->putJson("$this->uri/200", [
            "marca" => "VOLVO",
            "modelo" => "FHX",
            "placa" => "DEF456"
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_put_camion(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camion = Camion::firstOrFail();

        $response = $this->putJson("$this->uri/$camion->id", [
            "marca" => "VOLVO",
            "modelo" => "FHX",
            "placa" => "DEF456"
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_put_camion(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camion = Camion::firstOrFail();

        $response = $this->putJson("$this->uri/$camion->id", [
            "marca" => "VOLVO",
            "modelo" => "FHX",
            "placa" => "DEF456"
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_put_camion(): void
    {
        $camion = Camion::firstOrFail();

        $response = $this->putJson("$this->uri/$camion->id", [
            "marca" => "VOLVO",
            "modelo" => "FHX",
            "placa" => "DEF456"
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PATCH">

    // Case User Admin 1
    public function test_admin_can_patch_camion_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camion = Camion::firstOrFail();

        $response = $this->patchJson("$this->uri/$camion->id", [
            "placa" => fake()->bothify('???###')
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_patch_camion_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camion = Camion::firstOrFail();

        $response = $this->patchJson("$this->uri/$camion->id", [
            "placa" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_patch_camion_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->patchJson("$this->uri/200", [
            "placa" => fake()->bothify('???###')
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_patch_camion(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camion = Camion::firstOrFail();

        $response = $this->patchJson("$this->uri/$camion->id", [
            "placa" => fake()->bothify('???###')
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_patch_camion(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camion = Camion::firstOrFail();

        $response = $this->patchJson("$this->uri/$camion->id", [
            "placa" => fake()->bothify('???###')
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_patch_camion(): void
    {
        $camion = Camion::firstOrFail();

        $response = $this->patchJson("$this->uri/$camion->id", [
            "placa" => fake()->bothify('???###')
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of DELETE">

    // Case User Admin 1
    public function test_admin_can_delete_camion_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camion = Camion::firstOrFail();

        $response = $this->deleteJson("$this->uri/$camion->id");

        $response->assertStatus(200);
        $this->assertSoftDeleted('camiones', [
            "id" => $camion->id
        ]);
    }

    // Case User Admin 2
    public function test_admin_can_delete_camion_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->deleteJson("$this->uri/200");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_delete_camion(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camion = Camion::firstOrFail();

        $response = $this->deleteJson("$this->uri/$camion->id");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_delete_camion(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camion = Camion::firstOrFail();

        $response = $this->deleteJson("$this->uri/$camion->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_delete_camion(): void
    {
        $camion = Camion::firstOrFail();

        $response = $this->deleteJson("$this->uri/$camion->id");

        $response->assertStatus(401);
    }

    // </editor-fold>
}
