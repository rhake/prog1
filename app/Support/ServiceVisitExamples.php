<?php

namespace App\Support;

use App\Models\Garage;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Vehicle;

class ServiceVisitExamples
{
    public static function hydrateExisting(): void
    {
        self::ensureTowingExample();

        foreach (ServiceRequest::query()->get() as $request) {
            $type = mb_strtolower($request->service_type);

            if (str_contains($type, 'freio')) {
                self::brakes($request);
                continue;
            }

            if (str_contains($type, 'guincho') || str_contains($type, 'reboque')) {
                self::towing($request);
                continue;
            }

            $request->ensureChecklist();
        }
    }

    public static function brakes(ServiceRequest $request): void
    {
        $request->ensureChecklist();
        $request->update([
            'arrived_at' => now()->setTime(8, 12),
            'departed_at' => now()->setTime(11, 40),
            'provider_notes' => 'Pastilhas dianteiras no fim da vida. Disco com overheat leve. Cliente autorizou a troca. Sem ruído após o teste em rua.',
            'invoice_path' => 'images/examples/nf-vila-mariana.svg',
            'invoice_name' => 'NFS-e 000.128 — Mecânica Vila Mariana.svg',
        ]);

        self::photos($request, [
            ['service', 'images/examples/servico-pastilhas.svg', 'Pastilhas removidas'],
            ['service', 'images/examples/servico-disco.svg', 'Disco após retífica'],
            ['entry', 'images/examples/entrada-frente.svg', 'Frente na entrada'],
            ['entry', 'images/examples/entrada-traseira.svg', 'Traseira na entrada'],
            ['exit', 'images/examples/saida-lateral.svg', 'Lateral na saída'],
        ]);

        self::checklist($request, [
            'front_bumper' => ['damaged', 'Risco na ponta direita, já constava na entrada.'],
            'door_fl' => ['damaged', 'Pequeno amassado abaixo do retrovisor.'],
            'headlights' => ['ok', null],
            'spare_key' => ['missing', 'Cliente não deixou a reserva.'],
            'extinguisher' => ['na', 'Veículo isento.'],
        ]);
    }

    public static function towing(ServiceRequest $request): void
    {
        $request->ensureChecklist();
        $request->update([
            'arrived_at' => now()->subDay()->setTime(19, 5),
            'departed_at' => now()->subDay()->setTime(20, 18),
            'provider_notes' => 'Pane elétrica na Augusta. Guincho plataforma, transporte até a Oficina Central. Check-list feito na origem e na base.',
            'invoice_path' => 'images/examples/nf-oficina-central.svg',
            'invoice_name' => 'NFS-e 000.204 — Oficina Central.svg',
        ]);

        self::photos($request, [
            ['service', 'images/examples/guincho-engate.svg', 'Engate do reboque'],
            ['service', 'images/examples/guincho-plataforma.svg', 'Veículo na plataforma'],
            ['entry', 'images/examples/entrada-guincho.svg', 'Chegada na base'],
        ]);

        self::checklist($request, [
            'rear_bumper' => ['damaged', 'Risco de arrasto na parte baixa, já na origem.'],
            'wheels' => ['ok', null],
            'crlv' => ['ok', 'Documento no porta-luvas.'],
            'triangle' => ['ok', null],
            'spare_tire' => ['ok', null],
        ]);
    }

    /**
     * @param  list<array{0: string, 1: string, 2: ?string}>  $rows
     */
    private static function photos(ServiceRequest $request, array $rows): void
    {
        $request->photos()->delete();

        foreach ($rows as [$kind, $path, $caption]) {
            $request->photos()->create([
                'kind' => $kind,
                'path' => $path,
                'caption' => $caption,
            ]);
        }
    }

    /**
     * @param  array<string, array{0: string, 1: ?string}>  $overrides
     */
    private static function checklist(ServiceRequest $request, array $overrides): void
    {
        foreach ($request->checklistItems()->orderBy('sort_order')->get() as $item) {
            $item->update([
                'status' => $overrides[$item->code][0] ?? 'ok',
                'notes' => $overrides[$item->code][1] ?? null,
            ]);
        }
    }

    private static function ensureTowingExample(): void
    {
        $carlos = User::query()->where('email', 'carlos@email.com')->first();
        $corolla = $carlos?->vehicles()->where('model', 'Corolla')->first()
            ?? Vehicle::query()->where('model', 'Corolla')->first();
        $central = Garage::query()->where('name', 'Oficina Central')->first()
            ?? Garage::query()->first();
        $tow = Service::query()->where('service_name', 'Guincho 24h')->first();

        if (! $tow) {
            $tow = Service::create([
                'service_name' => 'Guincho 24h',
                'category' => 'Socorro',
                'average_price' => 320,
                'duration_minutes' => 90,
            ]);
        }

        if (! $carlos || ! $corolla || ! $central) {
            return;
        }

        $existing = ServiceRequest::query()
            ->where('user_id', $carlos->id)
            ->where(function ($query) use ($tow) {
                $query->where('service_id', $tow->id)
                    ->orWhere('service_type', 'like', '%Guincho%');
            })
            ->first();

        if ($existing) {
            return;
        }

        ServiceRequest::create([
            'user_id' => $carlos->id,
            'vehicle_id' => $corolla->id,
            'service_id' => $tow->id,
            'garage_id' => $central->id,
            'service_type' => $tow->service_name,
            'description' => 'Pane elétrica na Augusta. Pedido de reboque.',
            'status' => 'completed',
            'scheduled_date' => now()->subDay()->toDateString(),
        ]);
    }
}
