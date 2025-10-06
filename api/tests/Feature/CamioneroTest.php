<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Camionero;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CamioneroTest extends TestCase
{
    protected string $uri = "/api/camioneros";

    // <editor-fold desc="Tests of GET ALL">

    // Case User Admin
    public function test_admin_can_get_camioneros(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(200);
    }

    // Case User Camionero
    public function test_camionero_get_camioneros(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_get_camioneros(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson("$this->uri");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_get_camioneros(): void
    {
        $response = $this->getJson("$this->uri");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of GET BY ID">

    // Case User Admin 1
    public function test_admin_can_get_camionero_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();

        $response = $this->getJson("$this->uri/$camionero->id");

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_get_camionero_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson("$this->uri/200");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_camionero(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camioneroData = Camionero::firstOrFail();

        $response = $this->getJson("$this->uri/$camioneroData->id");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_get_camionero(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camionero = Camionero::firstOrFail();

        $response = $this->getJson("$this->uri/$camionero->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_get_camionero(): void
    {
        $camionero = Camionero::firstOrFail();

        $response = $this->getJson("$this->uri/$camionero->id");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of POST">

    // Case User Admin 1
    public function test_admin_can_create_camionero(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $userTemp = User::factory()->create();
        $userTemp->assignRole('camionero');

        $response = $this->postJson("$this->uri", [
            "user_id" => $userTemp->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('camioneros', [
            'user_id' => $userTemp->id,
        ]);
    }

    // Case User Admin 2
    public function test_admin_can_create_camionero_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $userTemp = User::factory()->create();
        $userTemp->assignRole('camionero');

        $response = $this->postJson("$this->uri", [
            "user_id" => $userTemp->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Camionero
    public function test_camionero_cannot_create_camionero(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $userTemp = User::factory()->create();
        $userTemp->assignRole('camionero');

        $response = $this->postJson("$this->uri", [
            "user_id" => $userTemp->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_create_camionero(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $userTemp = User::factory()->create();
        $userTemp->assignRole('camionero');

        $response = $this->postJson("$this->uri", [
            "user_id" => $userTemp->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_create_camionero(): void
    {
        $userTemp = User::factory()->create();
        $userTemp->assignRole('camionero');

        $response = $this->postJson("$this->uri", [
            "user_id" => $userTemp->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PUT">

    // Case User Admin 1
    public function test_admin_can_put_camionero_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();

        $response = $this->putJson("$this->uri/$camionero->id", [
            "user_id" => $camionero->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_put_camionero_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();

        $response = $this->putJson("$this->uri/$camionero->id", [
            "user_id" => $camionero->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_put_camionero_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->putJson("$this->uri/200", [
            "user_id" => 200,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_put_camionero(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camioneroData = Camionero::firstOrFail();

        $response = $this->putJson("$this->uri/$camioneroData->id", [
            "user_id" => $camioneroData->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(403);
    }

    // Case user Without Role
    public function test_user_without_role_cannot_put_camionero(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camionero = Camionero::firstOrFail();

        $response = $this->putJson("$this->uri/$camionero->id", [
            "user_id" => $camionero->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_camionero(): void
    {
        $camionero = Camionero::firstOrFail();

        $response = $this->putJson("$this->uri/$camionero->id", [
            "user_id" => $camionero->id,
            "documento" => fake()->numerify("##########"),
            "fecha_nacimiento" => now()->subYears(18)->toDateString(),
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PATCH">

    // Case User Admin 1
    public function test_admin_can_patch_camionero_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();

        $response = $this->patchJson("$this->uri/$camionero->id", [
            "user_id" => $camionero->id,
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_patch_camionero_info_incomplete(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();

        $response = $this->patchJson("$this->uri/$camionero->id", [
            "licencia" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_patch_camionero_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();

        $response = $this->patchJson("$this->uri/200", [
            "user_id" => $camionero->id,
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_patch_camionero(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camioneroData = Camionero::firstOrFail();

        $response = $this->patchJson("$this->uri/$camioneroData->id", [
            "user_id" => $camioneroData->id,
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_patch_camionero(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camionero = Camionero::firstOrFail();

        $response = $this->patchJson("$this->uri/$camionero->id", [
            "user_id" => $camionero->id,
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_patch_camionero(): void
    {
        $camionero = Camionero::firstOrFail();

        $response = $this->patchJson("$this->uri/$camionero->id", [
            "user_id" => $camionero->id,
            "licencia" => fake()->randomElement(["C2", "C3"])
        ]);

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of DELETE">

    // Case User Admin 1
    public function test_admin_can_delete_camionero_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();

        $response = $this->deleteJson("$this->uri/$camionero->id");

        $response->assertStatus(200);
        $this->assertSoftDeleted('camioneros', [
            "id" => $camionero->id
        ]);
    }

    // Case User Admin 2
    public function test_admin_can_delete_camionero_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $camionero = Camionero::firstOrFail();

        $response = $this->deleteJson("$this->uri/200");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_delete_camionero(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $camioneroData = Camionero::firstOrFail();

        $response = $this->deleteJson("$this->uri/$camioneroData->id");

        $response->assertStatus(403);
    }

    // Case User Without Role
    public function test_user_without_role_cannot_delete_camionero(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $camionero = Camionero::firstOrFail();

        $response = $this->deleteJson("$this->uri/$camionero->id");

        $response->assertStatus(403);
    }

    // Case User Guest
    public function test_user_guest_cannot_delete_camionero(): void
    {
        $camionero = Camionero::firstOrFail();

        $response = $this->deleteJson("$this->uri/$camionero->id");

        $response->assertStatus(401);
    }

    // </editor-fold>
}
