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
        Schema::create('grade_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_alternative')->constrained('alternatives')->onDelete('cascade');
            $table->foreignId('id_criteria')->constrained('criteria')->onDelete('cascade');
            $table->decimal('grade', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_criteria');
    }
};
