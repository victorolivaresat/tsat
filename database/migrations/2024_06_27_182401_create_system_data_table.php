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
        Schema::create('system_data', function (Blueprint $table) {
            $table->id();
            $table->string('cod_transaction')->unique();
            $table->timestamp('request_date');
            $table->timestamp('payment_date')->nullable();
            $table->string('user')->nullable();
            $table->string('cash_station')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('cci')->nullable();
            $table->string('payment_bank')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('commission', 15, 2)->nullable();
            $table->string('operation_number')->nullable();
            $table->string('status')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->string('payer')->nullable();
            $table->string('reason')->nullable();
            $table->string('receipt')->nullable();
            $table->string('type')->nullable();
            $table->string('approved_by')->nullable();
            $table->boolean('validated')->default(0);
            $table->string('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_data');
    }
};
