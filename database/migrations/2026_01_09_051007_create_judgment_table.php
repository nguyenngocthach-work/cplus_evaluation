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
        Schema::create('judgment', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('project_id');

            $table->integer('total_score')->nullable();
            $table->string('evaluator_notes', 255)->nullable();
            $table->foreign('project_id')
                    ->references('project_id')
                    ->on('project')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judgment');
    }
};