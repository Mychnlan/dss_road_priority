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
        Schema::create('criteria_pairwise', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('criteria_id_1');
            $table->unsignedBigInteger('criteria_id_2');
            $table->decimal('value', 5, 2); // nilai perbandingan (misal: 1 - 9, step 0.01)
            $table->timestamps();

            // Index dan foreign key (optional tapi recommended)
            $table->unique(['session_id', 'user_id', 'criteria_id_1', 'criteria_id_2'], 'unique_pairwise');

            // Tambahkan foreign keys jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_pairwise');
    }
};
