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
        Schema::create('rangking_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_alternative')->constrained('alternatives')->onDelete('cascade');
            $table->decimal('score', 10, 4);
            $table->integer('rank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rangking_results');
    }
};
