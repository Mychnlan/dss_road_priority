<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AHPController extends Controller
{
    public function calculate(Request $request)
    {
        $userId = Auth::id();
        $sessionId = $request->session_id;
        $comparisons = $request->input('comparisons');
        $criteria = DB::table('criteria')->get();

        $n = $criteria->count();
        $matrix = array_fill(0, $n, array_fill(0, $n, 1));
        $idIndexMap = $criteria->pluck('id')->flip();

        // Simpan nilai pairwise ke tabel baru
        foreach ($comparisons as $id1 => $values) {
            foreach ($values as $id2 => $value) {
                // simpan atau update nilai asli perbandingan
                DB::table('criteria_pairwise')->updateOrInsert(
                    [
                        'session_id' => $sessionId,
                        'user_id' => $userId,
                        'criteria_id_1' => $id1,
                        'criteria_id_2' => $id2
                    ],
                    ['value' => $value]
                );

                // Bangun matriks untuk perhitungan bobot
                $i = $idIndexMap[$id1];
                $j = $idIndexMap[$id2];
                $matrix[$i][$j] = $value;
                $matrix[$j][$i] = 1 / $value;
            }
        }

        // Normalisasi kolom
        $columnSums = array_fill(0, $n, 0);
        foreach ($matrix as $row) {
            foreach ($row as $j => $val) {
                $columnSums[$j] += $val;
            }
        }

        $normalized = [];
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $val) {
                $normalized[$i][$j] = $val / $columnSums[$j];
            }
        }

        // Hitung bobot rata-rata per baris
        $weights = [];
        foreach ($normalized as $i => $row) {
            $weights[$criteria[$i]->id] = array_sum($row) / $n;
        }

        foreach ($weights as $criteriaId => $weight) {
            DB::table('criteria_weights')->updateOrInsert(
                ['user_id' => $userId, 'session_id' => $request->session_id, 'criteria_id' => $criteriaId],
                ['weight' => $weight]
            );
        }

        return redirect()->back()->with('success', 'Bobot berhasil dihitung dengan AHP');
    }
}
