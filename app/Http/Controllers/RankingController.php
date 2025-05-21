<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\RankingResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function calculate($sessionId)
    {
        $userId = Auth::id();
    
        $alternatives = Alternative::with(['grades'])->where('session_id', $sessionId)->get();
        $criteria = Criteria::all();
    
        if ($alternatives->count() < 2) {
            return back()->with('error', 'Minimal 2 alternatif diperlukan untuk perhitungan.');
        }
    
        // Ambil bobot kriteria
        $weights = $this->getCriteriaWeights($userId, $sessionId, $criteria);
        $types = $criteria->pluck('type')->toArray();
    
        // Buat matriks keputusan
        $decisionMatrix = $this->buildDecisionMatrix($alternatives, $criteria);
    
        // Normalisasi matriks
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix, $types);
    
        // Hitung skor akhir
        $scores = $this->calculateScores($normalizedMatrix, $weights);
    
        // Simpan ke database
        $this->saveRankingResults($alternatives, $scores, $sessionId);
    
        return redirect()->back()->with('success', 'Perhitungan SAW berhasil dan hasil disimpan.');
    }
    
    private function getCriteriaWeights($userId, $sessionId, $criteria)
    {
        $criteriaWeights = DB::table('criteria_weights')
            ->where('user_id', $userId)
            ->where('session_id', $sessionId)
            ->pluck('weight', 'criteria_id');

        if ($criteriaWeights->count() < $criteria->count()) {
            return $criteria->pluck('weight', 'id')->values()->toArray();
        }

        return $criteria->pluck('id')->map(function ($id) use ($criteriaWeights) {
            return $criteriaWeights[$id] ?? 0;
        })->values()->toArray();
    }

    private function buildDecisionMatrix($alternatives, $criteria)
    {
        return $alternatives->map(function ($alt) use ($criteria) {
            return $criteria->map(function ($c) use ($alt) {
                $grade = $alt->grades->firstWhere('id_criteria', $c->id);
                return $grade ? $grade->grade : 0;
            })->toArray();
        })->toArray();
    }

    private function normalizeMatrix($matrix, $types)
    {
        $normalized = $matrix;
        $criteriaCount = count($matrix[0]);

        for ($j = 0; $j < $criteriaCount; $j++) {
            $column = array_column($matrix, $j);
            $max = max($column);
            $min = min($column);

            foreach ($normalized as $i => $row) {
                $normalized[$i][$j] = $types[$j] === 'benefit'
                    ? ($max != 0 ? $matrix[$i][$j] / $max : 0)
                    : ($matrix[$i][$j] != 0 ? $min / $matrix[$i][$j] : 0);
            }
        }

        return $normalized;
    }

    private function calculateScores($normalizedMatrix, $weights)
    {
        return array_map(function ($row) use ($weights) {
            return array_sum(array_map(function ($value, $weight) {
                return $value * $weight;
            }, $row, $weights));
        }, $normalizedMatrix);
    }

    private function saveRankingResults($alternatives, $scores, $sessionId)
    {
        DB::transaction(function () use ($alternatives, $scores, $sessionId) {
            // Menghapus hasil ranking lama berdasarkan session_id yang sudah ada di alternatives
            $altIds = $alternatives->pluck('id');
            RankingResult::whereIn('id_alternative', $altIds)->delete();
    
            // Menyimpan hasil ranking baru
            $results = $alternatives->map(function ($alt, $i) use ($scores) {
                return [
                    'id_alternative' => $alt->id,
                    'score' => $scores[$i]
                ];
            })->sortByDesc('score')->values();
    
            foreach ($results as $i => $res) {
                RankingResult::create([
                    'id_alternative' => $res['id_alternative'],
                    'score' => $res['score'],
                    'rank' => $i + 1
                ]);
            }
        });
    }
}
