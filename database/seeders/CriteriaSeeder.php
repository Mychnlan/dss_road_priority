<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('criteria')->insert([
            [
                'name_criteria' => 'Volume Lalu Lintas',
                'type' => 'benefit',
                'weight' => 0.1200,
            ],
            [
                'name_criteria' => 'Tingkat Kecelakaan',
                'type' => 'cost',
                'weight' => 0.2000,
            ],
            [
                'name_criteria' => 'Kondisi Jalan',
                'type' => 'benefit',
                'weight' => 0.5400,
            ],
            [
                'name_criteria' => 'Aksesibilitas',
                'type' => 'benefit',
                'weight' => 0.1500,
            ],
        ]);
    }
}
