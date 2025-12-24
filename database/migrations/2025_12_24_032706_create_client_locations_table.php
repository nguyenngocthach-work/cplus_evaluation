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
        Schema::create('client_locations', function (Blueprint $table) {
            $table->increments('client_location_id'); // PK đúng
            $table->string('client_HQ');
            $table->string('client_billing');
            $table->string('client_country');
            $table->string('client_city');
            $table->string('client_state_province');
            $table->string('client_zipcode');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();    
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_locations');
    }
};