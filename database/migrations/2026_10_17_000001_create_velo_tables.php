<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('brand');
            $table->string('model');
            $table->unsignedSmallInteger('year');
            $table->string('plate');
            $table->unsignedInteger('mileage')->default(0);
            $table->string('vin')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'plate']);
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->decimal('monthly_price', 10, 2);
            $table->string('description')->nullable();
            $table->json('services_included');
            $table->unsignedSmallInteger('max_services_per_year');
            $table->timestamps();
        });

        Schema::create('garages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('phone');
            $table->decimal('rating', 2, 1)->default(0);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->string('category');
            $table->decimal('average_price', 10, 2);
            $table->unsignedSmallInteger('duration_minutes');
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->restrictOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->date('renewal_date');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('garage_id')->nullable()->constrained()->nullOnDelete();
            $table->string('service_type');
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->date('scheduled_date')->nullable();
            $table->timestamps();
        });

        Schema::create('service_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('garage_id')->nullable()->constrained()->nullOnDelete();
            $table->date('service_date');
            $table->decimal('cost', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            $table->string('payment_status')->default('pending');
            $table->date('payment_date');
            $table->timestamps();
        });

        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->text('message');
            $table->boolean('read_status')->default(false);
            $table->timestamps();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('unique_id');
            $table->string('status')->default('unknown');
            $table->timestamp('last_update')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('speed', 8, 2)->default(0);
            $table->decimal('course', 6, 2)->default(0);
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
        Schema::dropIfExists('alerts');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('service_histories');
        Schema::dropIfExists('service_requests');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('services');
        Schema::dropIfExists('garages');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('vehicles');
    }
};
