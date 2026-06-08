<?php

namespace Tests\Feature;

use App\Models\Billing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ClientPortalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest is redirected to login from client portal.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/client/portal');
        $response->assertRedirect('/client/login');
    }

    /**
     * Test guest can access login page.
     */
    public function test_guest_can_access_login_page(): void
    {
        $response = $this->get('/client/login');
        $response->assertStatus(200);
        $response->assertSee('ACCESS PANEL');
    }

    /**
     * Test client registration.
     */
    public function test_client_can_register(): void
    {
        $component = Volt::test('pages.client.register')
            ->set('name', 'Ahmad Dani')
            ->set('email', 'dani@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register');

        $component->assertRedirect('/client/portal');

        $this->assertDatabaseHas('users', [
            'name' => 'Ahmad Dani',
            'email' => 'dani@example.com',
            'is_admin' => false,
        ]);
    }

    /**
     * Test client login.
     */
    public function test_client_can_login(): void
    {
        $user = User::create([
            'name' => 'Faisal',
            'email' => 'faisal@example.com',
            'password' => bcrypt('password123'),
        ]);

        $component = Volt::test('pages.client.login')
            ->set('email', 'faisal@example.com')
            ->set('password', 'password123')
            ->call('login');

        $component->assertRedirect('/client/portal');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test payment simulation update and WhatsApp log dispatch.
     */
    public function test_simulated_payment_updates_billing_and_logs_whatsapp(): void
    {
        $user = User::create([
            'name' => 'Hendra',
            'email' => 'hendra@example.com',
            'password' => bcrypt('password'),
        ]);

        $billing = Billing::create([
            'user_id' => $user->id,
            'title' => 'Layanan Cloud Hosting',
            'amount' => 500000,
            'billing_cycle' => 'monthly',
            'status' => 'pending',
            'due_date' => now()->addDays(5)->format('Y-m-d'),
            'whatsapp_number' => '081299998888',
        ]);

        $this->actingAs($user);

        Volt::test('pages.client.portal')
            ->set('paymentBillingId', $billing->id)
            ->call('simulatePayment');

        // Verify status changed to paid
        $this->assertEquals('paid', $billing->fresh()->status);

        // Verify WhatsApp log entry exists
        $this->assertDatabaseHas('whatsapp_reminders', [
            'billing_id' => $billing->id,
            'recipient_number' => '6281299998888',
            'status' => 'simulated',
        ]);
    }
}
