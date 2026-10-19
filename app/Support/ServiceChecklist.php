<?php

namespace App\Support;

class ServiceChecklist
{
    /**
     * @return list<array{code: string, area: string, label: string}>
     */
    public static function template(): array
    {
        return [
            ['code' => 'crlv', 'area' => 'Documentos e itens', 'label' => 'CRLV no veículo'],
            ['code' => 'spare_key', 'area' => 'Documentos e itens', 'label' => 'Chave reserva'],
            ['code' => 'triangle', 'area' => 'Documentos e itens', 'label' => 'Triângulo de sinalização'],
            ['code' => 'spare_tire', 'area' => 'Documentos e itens', 'label' => 'Estepe'],
            ['code' => 'jack', 'area' => 'Documentos e itens', 'label' => 'Macaco e chave de roda'],
            ['code' => 'extinguisher', 'area' => 'Documentos e itens', 'label' => 'Extintor'],
            ['code' => 'front_bumper', 'area' => 'Lataria e exterior', 'label' => 'Para-choque dianteiro'],
            ['code' => 'hood', 'area' => 'Lataria e exterior', 'label' => 'Capô'],
            ['code' => 'front_left', 'area' => 'Lataria e exterior', 'label' => 'Lateral dianteira esquerda'],
            ['code' => 'front_right', 'area' => 'Lataria e exterior', 'label' => 'Lateral dianteira direita'],
            ['code' => 'door_fl', 'area' => 'Lataria e exterior', 'label' => 'Porta dianteira esquerda'],
            ['code' => 'door_fr', 'area' => 'Lataria e exterior', 'label' => 'Porta dianteira direita'],
            ['code' => 'door_rl', 'area' => 'Lataria e exterior', 'label' => 'Porta traseira esquerda'],
            ['code' => 'door_rr', 'area' => 'Lataria e exterior', 'label' => 'Porta traseira direita'],
            ['code' => 'rear_bumper', 'area' => 'Lataria e exterior', 'label' => 'Para-choque traseiro'],
            ['code' => 'trunk', 'area' => 'Lataria e exterior', 'label' => 'Tampa traseira'],
            ['code' => 'roof', 'area' => 'Lataria e exterior', 'label' => 'Teto'],
            ['code' => 'windshield', 'area' => 'Vidros e iluminação', 'label' => 'Para-brisa'],
            ['code' => 'mirrors', 'area' => 'Vidros e iluminação', 'label' => 'Retrovisores'],
            ['code' => 'headlights', 'area' => 'Vidros e iluminação', 'label' => 'Faróis'],
            ['code' => 'taillights', 'area' => 'Vidros e iluminação', 'label' => 'Lanternas'],
            ['code' => 'tires', 'area' => 'Rodas e pneus', 'label' => 'Pneus'],
            ['code' => 'wheels', 'area' => 'Rodas e pneus', 'label' => 'Rodas / calotas'],
            ['code' => 'seats', 'area' => 'Interior', 'label' => 'Bancos'],
            ['code' => 'dashboard', 'area' => 'Interior', 'label' => 'Painel e volante'],
            ['code' => 'mats', 'area' => 'Interior', 'label' => 'Tapetes'],
        ];
    }
}
