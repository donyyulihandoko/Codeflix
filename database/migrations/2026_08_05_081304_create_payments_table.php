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

            // Relasi ke User & Paket Langganan
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();

            // Detail Transaksi
            $table->string('transaction_number')->unique(); // ID Transaksi Unik (Contoh: PAY-20260906-12345)
            $table->unsignedBigInteger('total_amount'); // Total Nominal Pembayaran

            // Status Pembayaran Midtrans
            // Status: pending, success, failed, expired, cancelled
            $table->string('status')->default('pending');

            // Snap Redirect URL / Token jika dibutuhkan untuk histori
            $table->string('midtrans_snap_token')->nullable();
            $table->string('payment_type')->nullable(); // Contoh: bank_transfer, gopay, credit_card

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
