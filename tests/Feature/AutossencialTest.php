<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutossencialTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shows_the_brand(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Autossencial')
            ->assertSee('saúde veicular')
            ->assertSee('Procure um ponto')
            ->assertSee('mais próximo')
            ->assertDontSee('/locale/en');
    }

    public function test_guest_cannot_open_the_app(): void
    {
        $this->get('/app')->assertRedirect('/login');
    }

    public function test_customer_can_sign_in_and_register_a_vehicle(): void
    {
        $user = User::factory()->create([
            'email' => 'carlos@email.com',
            'password' => 'user123',
            'role' => 'user',
            'status' => 'active',
        ]);

        $this->post('/login', [
            'email' => 'carlos@email.com',
            'password' => 'user123',
        ])->assertRedirect('/app');

        $this->post('/app/vehicles', [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2022,
            'plate' => 'abc1d23',
            'mileage' => 15000,
            'color' => 'Prata',
            'vin' => '9BR53ZEC5N8123456',
        ])->assertRedirect('/app/vehicles');

        $this->assertDatabaseHas('vehicles', [
            'user_id' => $user->id,
            'plate' => 'ABC1D23',
            'brand' => 'Toyota',
        ]);
    }

    public function test_customer_cannot_open_admin(): void
    {
        $user = User::factory()->create(['role' => 'user', 'status' => 'active']);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_open_the_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

        $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Autossencial');
    }

    public function test_customer_can_subscribe_a_plan(): void
    {
        $user = User::factory()->create(['role' => 'user', 'status' => 'active']);
        $vehicle = Vehicle::create([
            'user_id' => $user->id,
            'brand' => 'Honda',
            'model' => 'Civic',
            'year' => 2020,
            'plate' => 'XYZ9A87',
            'mileage' => 1000,
            'color' => 'Preto',
        ]);
        $plan = Plan::create([
            'plan_name' => 'Plus',
            'monthly_price' => 49,
            'description' => 'Cobertura',
            'services_included' => ['GPS'],
            'max_services_per_year' => 8,
        ]);

        $this->actingAs($user)->post('/app/plans', [
            'plan_id' => $plan->id,
            'vehicle_id' => $vehicle->id,
        ])->assertRedirect('/app/plans');

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'plan_id' => $plan->id,
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'payment_status' => 'paid',
        ]);
    }
}
