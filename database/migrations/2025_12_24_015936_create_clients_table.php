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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id');
            $table->string('client_name');
            $table->string('contact_number');
            $table->string('notes')->nullable();
            $table->string('email');
            $table->string('company_name');
            $table->string('client_contact_name');
            $table->tinyInteger('client_active');
            $table->timestamp('created_at', 6)->useCurrent();
            $table->timestamp('updated_at', 6)->useCurrentOnUpdate();
            $table->timestamp('deleted_at', 6)->nullable();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('project_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};