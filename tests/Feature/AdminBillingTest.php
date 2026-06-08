<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBillingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest is redirected to login.
     */
    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin/billings');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test admin can access admin billing index page.
     */
    public function test_admin_can_access_billings_page(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@dbaik.test',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/billings');

        $response->assertStatus(200);
        $response->assertSee('Billings & Invoices');
    }
}
