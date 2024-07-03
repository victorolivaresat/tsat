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
        Schema::create('ibk_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('ordering_company');
            $table->string('beneficiary');
            $table->string('account_charge');
            $table->string('account_destination');
            $table->string('payment_status');
            $table->string('number_application');
            $table->float('amount');
            $table->dateTime('date_time');
            $table->boolean('status')->default(0);
            $table->string('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibk_notifications');
    }
};
