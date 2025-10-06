<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TipoMercancia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TipoMercanciaTest extends TestCase
{
    // <editor-fold desc="Tests of GET ALL">

    // Case User Admin
    public function test_admin_can_get_tipos_mercancias(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/tipos_mercancias');

        $response->assertStatus(200);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_tipos_mercancias(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->getJson('/api/tipos_mercancias');

        $response->assertStatus(403);
    }

    // Case User No Authorized
    public function test_user_without_role_cannot_get_tipos_mercancias(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/tipos_mercancias');

        $response->assertStatus(403);
    }

    // Case User No Authenticated
    public function test_user_not_authenticated_cannot_get_tipos_mercancias(): void
    {
        $response = $this->getJson('/api/tipos_mercancias');

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of GET BY ID">

    // Case User Admin 1
    public function test_admin_can_get_tipo_mercancia_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $tipo = TipoMercancia::first();

        $response = $this->getJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_get_tipo_mercancia_but_by_non_existent_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/tipos_mercancias/200');

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_get_tipo_mercancia_by_existing_id(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->getJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(403);
    }

    // Case User No Authorized
    public function test_user_without_role_cannot_get_tipo_mercancia_by_existing_id(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->getJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(403);
    }

    // Case User No Authenticated
    public function test_user_not_authenticated_cannot_get_tipo_mercancia_by_existing_id(): void
    {
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->getJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of POST">

    // Case User Admin 1
    public function test_admin_can_create_tipo_mercancia(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/tipos_mercancias', [
            'tipo' => 'Frágil'
        ]);

        $response->assertStatus(201);
    }

    // Case User Admin 2
    public function test_admin_can_create_tipo_mercancia_incorrect(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/tipos_mercancias', [
            'tipo' => ''
        ]);

        $response->assertStatus(422);
    }

    // Case User Camionero
    public function test_camionero_cannot_create_tipo_mercancia(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $response = $this->postJson('/api/tipos_mercancias');

        $response->assertStatus(403);
    }

    // Case User No Authorized
    public function test_user_without_role_create_tipo_mercancia(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/tipos_mercancias');

        $response->assertStatus(403);
    }

    // Case User No Authenticated
    public function test_user_no_authenticated_create_tipo_mercancia(): void
    {
        $response = $this->postJson('/api/tipos_mercancias');

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PUT">

    // Case User Admin 1
    public function test_admin_can_update_tipo_mercancia_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("/api/tipos_mercancias/$tipo->id", [
            "tipo" => "Inflamable"
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_update_info_incomplete_tipo_mercancia(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("/api/tipos_mercancias/$tipo->id", [
            "tipo" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_update_but_by_non_existent_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->putJson('/api/tipos_mercancias/200');

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_update_tipo_mercancia(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(403);
    }

    // Case User No Authorized
    public function test_user_without_role_cannot_update_tipo_mercancia(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(403);
    }

    // Case User No Authenticated
    public function test_user_not_authenticated_cannot_update_tipo_mercancia(): void
    {
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->putJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of PATCH">

    // Case User Admin 1
    public function test_admin_can_patch_tipo_mercancia_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->patchJson("/api/tipos_mercancias/$tipo->id", [
            "tipo" => "Inflamable"
        ]);

        $response->assertStatus(200);
    }

    // Case User Admin 2
    public function test_admin_can_patch_info_incomplete_tipo_mercancia(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->patchJson("/api/tipos_mercancias/$tipo->id", [
            "tipo" => ""
        ]);

        $response->assertStatus(422);
    }

    // Case User Admin 3
    public function test_admin_can_patch_tipo_mercancia_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->patchJson("/api/tipos_mercancias/200", [
            "tipo" => "Inflamable"
        ]);

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_patch_tipo_mercancia(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->getJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(403);
    }

    // Case User No Authorized
    public function test_user_without_role_cannot_patch_tipo_mercancia(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->getJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(403);
    }

    // Case User No Authenticated
    public function test_user_not_authenticated_cannot_patch_tipo_mercancia(): void
    {
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->getJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(401);
    }

    // </editor-fold>

    // <editor-fold desc="Tests of DELETE">

    // Case User Admin 1
    public function test_admin_can_delete_tipo_mercancia_by_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->deleteJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(200);
        $this->assertSoftDeleted('tipos_mercancias', [
            "id" => $tipo->id
        ]);
    }

    // Case User Admin 2
    public function test_admin_can_delete_tipo_mercancia_by_non_existing_id(): void
    {
        $admin = User::role('admin')->firstOrFail();

        Sanctum::actingAs($admin);

        $response = $this->deleteJson("/api/tipos_mercancias/200");

        $response->assertStatus(404);
    }

    // Case User Camionero
    public function test_camionero_cannot_delete_tipo_mercancia(): void
    {
        $camionero = User::role('camionero')->firstOrFail();

        Sanctum::actingAs($camionero);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->deleteJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(403);
    }

    // Case User No Authorized
    public function test_user_without_role_cannot_delete_tipo_mercancia(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $tipo = TipoMercancia::firstOrFail();

        $response = $this->deleteJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(403);
    }

    // Case User No Authenticated
    public function test_user_not_authorized_cannot_delete_tipo_mercancia(): void
    {
        $tipo = TipoMercancia::firstOrFail();

        $response = $this->deleteJson("/api/tipos_mercancias/$tipo->id");

        $response->assertStatus(401);
    }

    // </editor-fold>
}
