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
        Schema::create('bcp_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('operation_type');
            $table->dateTime('date_time');
            $table->string('operation_number');
            $table->string('ordering_company');
            $table->string('account_charge');
            $table->string('beneficiary');
            $table->string('account_destination');
            $table->float('amount');
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
        Schema::dropIfExists('bcp_notifications');
    }
};
