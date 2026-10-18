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
            ->assertSee('viewBox="0 0 1553 268"', false)
            ->assertDontSee('site-brand-name', false)
            ->assertDontSee('images/mark.png', false)
            ->assertSee('saúde veicular')
            ->assertSee('Procure um ponto')
            ->assertSee('mais próximo')
            ->assertSee('Links importantes')
            ->assertSee('Precisa de ajuda?')
            ->assertSee('Assine agora')
            ->assertSee('Criar conta')
            ->assertSee('Falar com um consultor')
            ->assertDontSee('/locale/en');
    }

    public function test_css_logo_page_is_public(): void
    {
        $this->get('/logo')
            ->assertOk()
            ->assertSee('Símbolo em CSS')
            ->assertSee('Só as setas')
            ->assertSee('íris em PNG')
            ->assertSee('volta de frases')
            ->assertSee('Plano de saúde veicular')
            ->assertSee('clip-path: polygon', false)
            ->assertSee('images/mark-iris.png', false);
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

    public function test_customer_can_open_service_visit_details(): void
    {
        $this->seed();

        $carlos = User::query()->where('email', 'carlos@email.com')->firstOrFail();
        $brakes = \App\Models\ServiceRequest::query()
            ->where('user_id', $carlos->id)
            ->where('service_type', 'Inspeção de Freios')
            ->firstOrFail();

        $this->actingAs($carlos)
            ->get('/app/services/'.$brakes->id)
            ->assertOk()
            ->assertSee('Inspeção de Freios')
            ->assertSee('Entrada do veículo')
            ->assertSee('Saída do veículo')
            ->assertSee('Nota fiscal')
            ->assertSee('NFS-e 000.128')
            ->assertSee('Fotos do serviço')
            ->assertSee('Pastilhas removidas')
            ->assertSee('Fotos de entrada')
            ->assertSee('Frente na entrada')
            ->assertSee('Fotos de saída')
            ->assertSee('Check-list de itens')
            ->assertSee('Para-choque dianteiro')
            ->assertSee('Risco na ponta direita')
            ->assertSee('Anotações do prestador')
            ->assertSee('Pastilhas dianteiras');
    }

    public function test_customer_cannot_open_another_users_service(): void
    {
        $this->seed();

        $ana = User::query()->where('email', 'ana@email.com')->firstOrFail();
        $brakes = \App\Models\ServiceRequest::query()
            ->where('service_type', 'Inspeção de Freios')
            ->firstOrFail();

        $this->actingAs($ana)->get('/app/services/'.$brakes->id)->assertForbidden();
    }

    public function test_admin_can_edit_service_visit_details(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@autossencial.com')->firstOrFail();
        $brakes = \App\Models\ServiceRequest::query()
            ->where('service_type', 'Inspeção de Freios')
            ->firstOrFail();
        $item = $brakes->checklistItems()->where('code', 'front_bumper')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin/services/'.$brakes->id)
            ->assertOk()
            ->assertSee('Horários e anotações')
            ->assertSee('Check-list de itens')
            ->assertSee('Nota fiscal');

        $this->actingAs($admin)->patch('/admin/services/'.$brakes->id.'/visit', [
            'arrived_at' => '2026-10-18T08:00',
            'departed_at' => '2026-10-18T12:30',
            'provider_notes' => 'Cliente acompanhou o teste de rua.',
        ])->assertRedirect();

        $this->assertDatabaseHas('service_requests', [
            'id' => $brakes->id,
            'provider_notes' => 'Cliente acompanhou o teste de rua.',
        ]);

        $this->actingAs($admin)->patch('/admin/services/'.$brakes->id.'/checklist', [
            'items' => [
                $item->id => ['status' => 'damaged', 'notes' => 'Amassado novo na ponta.'],
            ],
        ])->assertRedirect();

        $this->assertDatabaseHas('service_checklist_items', [
            'id' => $item->id,
            'status' => 'damaged',
            'notes' => 'Amassado novo na ponta.',
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->create('disco.jpg', 24, 'image/jpeg');

        $this->actingAs($admin)->post('/admin/services/'.$brakes->id.'/photos', [
            'kind' => 'service',
            'caption' => 'Disco após limpeza',
            'photos' => [$file],
        ])->assertRedirect();

        $this->assertDatabaseHas('service_photos', [
            'service_request_id' => $brakes->id,
            'kind' => 'service',
            'caption' => 'Disco após limpeza',
        ]);
    }
}
