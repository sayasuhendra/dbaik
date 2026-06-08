<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSupportTicketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest is redirected to login.
     */
    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin/support-tickets');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test admin can access admin support tickets index page.
     */
    public function test_admin_can_access_support_tickets_page(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@dbaik.test',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/support-tickets');

        $response->assertStatus(200);
        $response->assertSee('Support Tickets');
    }
}
