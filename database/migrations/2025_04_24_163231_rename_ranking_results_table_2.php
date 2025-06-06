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
        Schema::rename('rangking_results', 'ranking_results');
    }

    public function down(): void
    {
        Schema::rename('ranking_results', 'rangking_results');
    }
};
