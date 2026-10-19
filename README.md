# Autossencial

Plano de saúde veicular. Site em Laravel com MySQL: página inicial, cadastro, painel do cliente e painel administrativo.

O cliente acompanha veículos, solicita serviços em oficinas, consulta o mapa, assina planos e recebe alertas. O administrador gerencia usuários, veículos, serviços, oficinas, planos, pagamentos e alertas.

## Requisitos

- PHP 8.3+ com as extensões `mbstring`, `xml`, `curl`, `zip`, `bcmath`, `mysql` e `sqlite` (testes)
- Composer
- MySQL ou MariaDB

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Crie o banco e o usuário indicados no `.env` (`velo` / `velo` em `127.0.0.1:3306`), depois:

```bash
php artisan migrate --seed
php artisan serve
```

O site abre em `http://127.0.0.1:8000`.

## Contas de demonstração

| Papel | E-mail | Senha |
| --- | --- | --- |
| Admin | admin@autossencial.com | admin123 |
| Cliente | carlos@email.com | user123 |

## Testes

```bash
php artisan test
```

Os testes usam SQLite em memória e não alteram o banco MySQL.
