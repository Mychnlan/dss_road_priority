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
        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('dss_sessions')->onDelete('cascade');
            $table->string('name_alternative');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatives');
    }
};
