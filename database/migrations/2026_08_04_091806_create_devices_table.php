<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel users dengan cascade delete
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('device_name', 150); // e.g. "Chrome on Windows"
            $table->string('device_id', 255);   // Diperbesar ke 255 agar muat hash fingerprint apa saja

            $table->string('device_type', 50)->nullable();     // e.g. desktop, mobile, tablet
            $table->string('platform', 100)->nullable();        // e.g. Windows, iOS, Android
            $table->string('platform_version', 50)->nullable(); // e.g. 10.0, 17.2
            $table->string('browser', 100)->nullable();         // e.g. Chrome, Safari
            $table->string('browser_version', 50)->nullable();  // e.g. 120.0

            $table->timestamp('last_active')->nullable();
            $table->timestamps();

            // 1. Composite Unique: Kombinasi user_id dan device_id harus unik
            // Mencegah duplicate row untuk device yang sama pada user yang sama
            $table->unique(['user_id', 'device_id'], 'user_device_unique');

            // 2. Index untuk mempercepat query berdasarkan last_active (misal: Cek device online/cleanup)
            $table->index('last_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
