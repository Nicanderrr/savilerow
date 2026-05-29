<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('traffic_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('ip_hash', 64)->nullable()->index();
            $table->string('method', 10);
            $table->string('path')->index();
            $table->string('route_name')->nullable()->index();
            $table->unsignedSmallInteger('status_code')->nullable();
            $table->string('referer')->nullable();
            $table->string('user_agent', 600)->nullable();
            $table->string('device_type')->nullable()->index();
            $table->string('country_code', 2)->nullable()->index();
            $table->string('country')->nullable()->index();
            $table->string('region')->nullable()->index();
            $table->string('city')->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->timestamp('visited_at')->index();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('tracking_number');
            $table->string('country_code', 2)->nullable()->after('ip_address');
            $table->string('country')->nullable()->after('country_code');
            $table->string('region')->nullable()->after('country');
            $table->string('city')->nullable()->after('region');
            $table->decimal('latitude', 10, 7)->nullable()->after('city');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'country_code', 'country', 'region', 'city', 'latitude', 'longitude']);
        });

        Schema::dropIfExists('traffic_logs');
    }
};
