<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->timestamp('arrived_at')->nullable()->after('scheduled_date');
            $table->timestamp('departed_at')->nullable()->after('arrived_at');
            $table->text('provider_notes')->nullable()->after('departed_at');
            $table->string('invoice_path')->nullable()->after('provider_notes');
            $table->string('invoice_name')->nullable()->after('invoice_path');
        });

        Schema::create('service_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained()->cascadeOnDelete();
            $table->string('kind');
            $table->string('path');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        Schema::create('service_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('area');
            $table->string('label');
            $table->string('status')->default('pending');
            $table->string('notes')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_checklist_items');
        Schema::dropIfExists('service_photos');

        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'arrived_at',
                'departed_at',
                'provider_notes',
                'invoice_path',
                'invoice_name',
            ]);
        });
    }
};
