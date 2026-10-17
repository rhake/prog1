<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Device;
use App\Models\Garage;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Service;
use App\Models\ServiceHistory;
use App\Models\ServiceRequest;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VeloSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Autossencial',
            'email' => 'admin@autossencial.com',
            'password' => 'admin123',
            'phone' => '(11) 4000-1000',
            'address' => 'Av. Paulista, 1000 - Bela Vista, São Paulo',
            'status' => 'active',
            'role' => 'admin',
        ]);

        $carlos = User::create([
            'name' => 'Carlos Silva',
            'email' => 'carlos@email.com',
            'password' => 'user123',
            'phone' => '(11) 98888-1111',
            'address' => 'Rua Augusta, 500 - Consolação, São Paulo',
            'status' => 'active',
            'role' => 'user',
        ]);

        $ana = User::create([
            'name' => 'Ana Oliveira',
            'email' => 'ana@email.com',
            'password' => 'user123',
            'phone' => '(11) 97777-2222',
            'address' => 'Rua Harmonia, 220 - Vila Madalena, São Paulo',
            'status' => 'active',
            'role' => 'user',
        ]);

        $pedro = User::create([
            'name' => 'Pedro Lima',
            'email' => 'pedro@email.com',
            'password' => 'user123',
            'phone' => '(11) 96666-3333',
            'address' => 'Rua Domingos de Morais, 800 - Vila Mariana, São Paulo',
            'status' => 'inactive',
            'role' => 'user',
        ]);

        $basic = Plan::create([
            'plan_name' => 'Basic',
            'monthly_price' => 20,
            'description' => 'Manutenção essencial para o dia a dia.',
            'services_included' => ['Troca de Óleo', 'Inspeção de Freios', 'Check-up Básico'],
            'max_services_per_year' => 4,
        ]);

        $plus = Plan::create([
            'plan_name' => 'Plus',
            'monthly_price' => 49,
            'description' => 'Cobertura completa com rastreamento GPS.',
            'services_included' => ['Tudo do Basic', 'Check-up Completo', 'Diagnóstico de Injeção', 'Rastreamento GPS'],
            'max_services_per_year' => 8,
        ]);

        $premium = Plan::create([
            'plan_name' => 'Premium',
            'monthly_price' => 99,
            'description' => 'Proteção total, guincho 24h e carro reserva.',
            'services_included' => ['Tudo do Plus', 'Cobertura a Terceiros', 'Guincho 24h', 'Carro Reserva'],
            'max_services_per_year' => 12,
        ]);

        $central = Garage::create([
            'name' => 'Oficina Central',
            'address' => 'Av. Paulista, 1500',
            'city' => 'São Paulo',
            'latitude' => -23.5614140,
            'longitude' => -46.6558810,
            'phone' => '(11) 3000-1000',
            'rating' => 4.8,
        ]);

        $moema = Garage::create([
            'name' => 'AutoPrime Moema',
            'address' => 'Av. Ibirapuera, 3100',
            'city' => 'São Paulo',
            'latitude' => -23.6100000,
            'longitude' => -46.6652000,
            'phone' => '(11) 3000-2200',
            'rating' => 4.6,
        ]);

        $vila = Garage::create([
            'name' => 'Mecânica Vila Mariana',
            'address' => 'Rua Domingos de Morais, 1200',
            'city' => 'São Paulo',
            'latitude' => -23.5889000,
            'longitude' => -46.6348000,
            'phone' => '(11) 3000-3300',
            'rating' => 4.9,
        ]);

        $oil = Service::create(['service_name' => 'Troca de Óleo', 'category' => 'Manutenção', 'average_price' => 180, 'duration_minutes' => 45]);
        $brakes = Service::create(['service_name' => 'Inspeção de Freios', 'category' => 'Segurança', 'average_price' => 220, 'duration_minutes' => 60]);
        $basicCheck = Service::create(['service_name' => 'Check-up Básico', 'category' => 'Revisão', 'average_price' => 150, 'duration_minutes' => 40]);
        $fullCheck = Service::create(['service_name' => 'Check-up Completo', 'category' => 'Revisão', 'average_price' => 450, 'duration_minutes' => 120]);
        $injection = Service::create(['service_name' => 'Diagnóstico de Injeção', 'category' => 'Motor', 'average_price' => 280, 'duration_minutes' => 90]);
        Service::create(['service_name' => 'Alinhamento e Balanceamento', 'category' => 'Pneus', 'average_price' => 160, 'duration_minutes' => 50]);

        $corolla = Vehicle::create([
            'user_id' => $carlos->id,
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2022,
            'plate' => 'ABC1D23',
            'mileage' => 45200,
            'vin' => '9BR53ZEC5N8123456',
            'color' => 'Prata',
        ]);

        $civic = Vehicle::create([
            'user_id' => $carlos->id,
            'brand' => 'Honda',
            'model' => 'Civic',
            'year' => 2019,
            'plate' => 'DEF2E34',
            'mileage' => 78120,
            'vin' => '93HFC2650KZ123456',
            'color' => 'Preto',
        ]);

        $tcross = Vehicle::create([
            'user_id' => $ana->id,
            'brand' => 'Volkswagen',
            'model' => 'T-Cross',
            'year' => 2023,
            'plate' => 'GHI3F45',
            'mileage' => 22150,
            'vin' => '9BWAG45U0PT123456',
            'color' => 'Branco',
        ]);

        $onix = Vehicle::create([
            'user_id' => $pedro->id,
            'brand' => 'Chevrolet',
            'model' => 'Onix',
            'year' => 2021,
            'plate' => 'JKL4G56',
            'mileage' => 53400,
            'vin' => '9BGKS48A0MG123456',
            'color' => 'Vermelho',
        ]);

        $subCarlos = Subscription::create([
            'user_id' => $carlos->id,
            'vehicle_id' => $corolla->id,
            'plan_id' => $plus->id,
            'start_date' => now()->subMonths(3)->toDateString(),
            'end_date' => now()->addMonths(9)->toDateString(),
            'renewal_date' => now()->addDays(12)->toDateString(),
            'status' => 'active',
        ]);

        $subAna = Subscription::create([
            'user_id' => $ana->id,
            'vehicle_id' => $tcross->id,
            'plan_id' => $premium->id,
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonths(11)->toDateString(),
            'renewal_date' => now()->addDays(20)->toDateString(),
            'status' => 'active',
        ]);

        Subscription::create([
            'user_id' => $pedro->id,
            'vehicle_id' => $onix->id,
            'plan_id' => $basic->id,
            'start_date' => now()->subMonths(8)->toDateString(),
            'end_date' => now()->subDays(4)->toDateString(),
            'renewal_date' => now()->subDays(4)->toDateString(),
            'status' => 'expired',
        ]);

        Payment::create([
            'user_id' => $carlos->id,
            'subscription_id' => $subCarlos->id,
            'amount' => $plus->monthly_price,
            'payment_method' => 'pix',
            'payment_status' => 'paid',
            'payment_date' => now()->subDays(12)->toDateString(),
        ]);

        Payment::create([
            'user_id' => $ana->id,
            'subscription_id' => $subAna->id,
            'amount' => $premium->monthly_price,
            'payment_method' => 'credit_card',
            'payment_status' => 'paid',
            'payment_date' => now()->subDays(5)->toDateString(),
        ]);

        Payment::create([
            'user_id' => $pedro->id,
            'subscription_id' => Subscription::query()->where('user_id', $pedro->id)->first()->id,
            'amount' => $basic->monthly_price,
            'payment_method' => 'boleto',
            'payment_status' => 'pending',
            'payment_date' => now()->subDays(2)->toDateString(),
        ]);

        ServiceRequest::create([
            'user_id' => $carlos->id,
            'vehicle_id' => $corolla->id,
            'service_id' => $oil->id,
            'garage_id' => $central->id,
            'service_type' => $oil->service_name,
            'description' => 'Troca de óleo e filtro do Corolla.',
            'status' => 'pending',
            'scheduled_date' => now()->addDays(2)->toDateString(),
        ]);

        ServiceRequest::create([
            'user_id' => $carlos->id,
            'vehicle_id' => $civic->id,
            'service_id' => $brakes->id,
            'garage_id' => $vila->id,
            'service_type' => $brakes->service_name,
            'description' => 'Ruído ao frear em baixa velocidade.',
            'status' => 'in_progress',
            'scheduled_date' => now()->toDateString(),
        ]);

        ServiceRequest::create([
            'user_id' => $ana->id,
            'vehicle_id' => $tcross->id,
            'service_id' => $fullCheck->id,
            'garage_id' => $moema->id,
            'service_type' => $fullCheck->service_name,
            'description' => 'Revisão dos 20 mil km.',
            'status' => 'accepted',
            'scheduled_date' => now()->addDays(5)->toDateString(),
        ]);

        ServiceHistory::create([
            'vehicle_id' => $corolla->id,
            'service_id' => $basicCheck->id,
            'garage_id' => $central->id,
            'service_date' => now()->subMonths(4)->toDateString(),
            'cost' => $basicCheck->average_price,
            'notes' => 'Filtros e fluidos conferidos. Sem pendências.',
        ]);

        ServiceHistory::create([
            'vehicle_id' => $corolla->id,
            'service_id' => $injection->id,
            'garage_id' => $vila->id,
            'service_date' => now()->subMonths(1)->toDateString(),
            'cost' => $injection->average_price,
            'notes' => 'Bicos limpos e falha intermitente resolvida.',
        ]);

        Alert::create([
            'user_id' => $carlos->id,
            'type' => 'reminder',
            'message' => 'A troca de óleo do Corolla está agendada para daqui a 2 dias.',
            'read_status' => false,
        ])->forceFill(['created_at' => now()->subHours(3)])->save();

        Alert::create([
            'user_id' => $carlos->id,
            'type' => 'payment',
            'message' => 'Pagamento do plano Plus confirmado via PIX.',
            'read_status' => false,
        ])->forceFill(['created_at' => now()->subDay()])->save();

        Alert::create([
            'user_id' => $carlos->id,
            'type' => 'service_update',
            'message' => 'A inspeção de freios do Civic está em andamento na Mecânica Vila Mariana.',
            'read_status' => true,
        ])->forceFill(['created_at' => now()->subDays(2)])->save();

        Alert::create([
            'user_id' => $ana->id,
            'type' => 'promotion',
            'message' => 'O plano Premium inclui guincho 24h. Confira a cobertura do seu T-Cross.',
            'read_status' => false,
        ]);

        $this->device($carlos, $corolla, 'Corolla ABC1D23', 'AUTO-COROLLA-01', 'online', -23.5505200, -46.6333080, 'Av. Paulista, 900 - Bela Vista', 32);
        $this->device($carlos, $civic, 'Civic DEF2E34', 'AUTO-CIVIC-02', 'offline', -23.5614000, -46.6822000, 'Rua dos Pinheiros, 400 - Pinheiros', 0);
        $this->device($ana, $tcross, 'T-Cross GHI3F45', 'AUTO-TCROSS-03', 'online', -23.6012000, -46.6658000, 'Av. Ibirapuera, 2800 - Moema', 18);
        $this->device($pedro, $onix, 'Onix JKL4G56', 'AUTO-ONIX-04', 'unknown', -23.5895000, -46.6342000, 'Rua Domingos de Morais, 700 - Vila Mariana', 0);

        unset($admin);
    }

    private function device(User $user, Vehicle $vehicle, string $name, string $uniqueId, string $status, float $lat, float $lng, string $address, float $speed): void
    {
        Device::create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'name' => $name,
            'unique_id' => $uniqueId,
            'status' => $status,
            'last_update' => now()->subMinutes($status === 'online' ? 2 : 90),
            'latitude' => $lat,
            'longitude' => $lng,
            'speed' => $speed,
            'course' => 80,
            'address' => $address,
        ]);
    }
}
