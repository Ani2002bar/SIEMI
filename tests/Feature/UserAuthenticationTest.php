<?php


namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class RolePermissionsTest extends TestCase
{
    /**
     * Test that admin can access admin routes.
     */
    public function test_admin_can_access_admin_routes()
    {
        $admin = User::where('email', 'admin@gmail.com')->first();

        $this->actingAs($admin);

        $response = $this->get('/users');
        $response->assertStatus(200); // Admin puede acceder
    }

    /**
     * Test that normal user cannot access admin routes.
     */
    public function test_user_cannot_access_admin_routes()
    {
        $user = User::where('email', 'user@gmail.com')->first();

        $this->actingAs($user);

        $response = $this->get('/users');
        $response->assertStatus(403); // Usuario no tiene permiso
    }

    /**
     * Test that normal user can access their allowed routes.
     */
    public function test_user_can_access_user_routes()
    {
        $user = User::where('email', 'user@gmail.com')->first();

        $this->actingAs($user);

        $response = $this->get('/mantenimientos');
        $response->assertStatus(200); // Usuario puede acceder
    }
}
