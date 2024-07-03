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
        Schema::create('reconciliations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('system_data_id');
            $table->unsignedBigInteger('bcp_notification_id')->nullable();
            $table->unsignedBigInteger('ibk_notification_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('system_data_id')->references('id')->on('system_data');
            $table->foreign('bcp_notification_id')->references('id')->on('bcp_notifications');
            $table->foreign('ibk_notification_id')->references('id')->on('ibk_notifications');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reconciliations');
    }
};
