<?php

namespace App\Support;

class Labels
{
    public static function money(float|int|string|null $value): string
    {
        $number = (float) $value;
        $decimals = abs($number - round($number)) < 0.001 ? 0 : 2;

        return 'R$'.number_format($number, $decimals, ',', '.');
    }

    public static function km(int|string|null $value): string
    {
        return number_format((int) $value, 0, ',', '.').' km';
    }

    /**
     * @return array{0: string, 1: string}
     */
    public static function status(string $status): array
    {
        return match ($status) {
            'pending' => [__('Pendente'), 'warn'],
            'accepted' => [__('Aceito'), 'info'],
            'denied' => [__('Recusado'), 'danger'],
            'in_progress' => [__('Em andamento'), 'primary'],
            'completed' => [__('Concluído'), 'ok'],
            'cancelled' => [__('Cancelado'), 'muted'],
            'active' => [__('Ativo'), 'ok'],
            'inactive' => [__('Inativo'), 'muted'],
            'suspended' => [__('Suspenso'), 'danger'],
            'expired' => [__('Expirado'), 'muted'],
            'paid' => [__('Pago'), 'ok'],
            'failed' => [__('Falhou'), 'danger'],
            'refunded' => [__('Estornado'), 'info'],
            'online' => [__('Online'), 'ok'],
            'offline' => [__('Offline'), 'muted'],
            'unknown' => [__('Sem sinal'), 'warn'],
            'credit_card' => [__('Cartão de crédito'), 'muted'],
            'debit_card' => [__('Cartão de débito'), 'muted'],
            'pix' => ['PIX', 'muted'],
            'boleto' => [__('Boleto'), 'muted'],
            'service_update' => [__('Serviço'), 'primary'],
            'payment' => [__('Pagamento'), 'ok'],
            'reminder' => [__('Lembrete'), 'warn'],
            'promotion' => [__('Promoção'), 'info'],
            'alert' => [__('Alerta'), 'danger'],
            default => [$status, 'muted'],
        };
    }
}
