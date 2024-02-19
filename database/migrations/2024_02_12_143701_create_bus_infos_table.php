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
        Schema::create('bus_infos', function (Blueprint $table) {
            $table->id();
            $table->string('bus_code',6)->unique();
            $table->string('bus_model');
            $table->string('plate_no',10)->nullable();
            $table->integer('merchant_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_infos');
    }
};
