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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Menggunakan cascadeOnDelete agar terintegrasi dengan baik
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();

            $table->string('transaction_number')->unique();
            $table->decimal('total_amount', 12, 2);

            // Disesuaikan dengan payload callback asli Midtrans Snap
            $table->enum('payment_status', [
                'pending',
                'settlement', // Status sukses utama Midtrans
                'capture',    // Untuk kartu kredit
                'success',
                'cancel',
                'deny',
                'expire',
                'failure'
            ])->default('pending');

            $table->string('midtrans_snap_token')->nullable();
            $table->string('midtrans_booking_code')->nullable();
            $table->string('midtrans_transaction_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
