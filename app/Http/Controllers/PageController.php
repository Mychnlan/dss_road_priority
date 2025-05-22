<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\DssSession;
use App\Models\RankingResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PageController extends Controller
{
    public function dashboard(): View
    {

        $userId = Auth::id();

        // Hitung jumlah sesi perhitungan milik user ini
        $sessionCount = DssSession::where('user_id', $userId)->count();

        return view('dashboard', compact('sessionCount'));
    }

    public function spk(): View
    {
        $sessions = DssSession::where('user_id', Auth::id())->get();
        return view('spk.index', compact('sessions'));
    }

    public function weight($sessionId): View
    {
        $userId = Auth::id();

        // Ambil semua kriteria
        $criteria = DB::table('criteria')->get();

        // Ambil nilai pairwise dari tabel criteria_pairwise
        $pairwiseRaw = DB::table('criteria_pairwise')
            ->where('session_id', $sessionId)
            ->where('user_id', $userId)
            ->get(); // gunakan get() saja, pluck tidak cocok di sini

        // Buat array asosiatif [criteria_id_1][criteria_id_2] => value
        $pairwiseValues = [];
        foreach ($pairwiseRaw as $item) {
            $pairwiseValues[$item->criteria_id_1][$item->criteria_id_2] = $item->value;
        }

        // Buat pasangan kriteria untuk form
        $pairwiseComparisons = [];
        foreach ($criteria as $i => $c1) {
            for ($j = $i + 1; $j < $criteria->count(); $j++) {
                $c2 = $criteria[$j];
                $pairwiseComparisons[] = [
                    'kriteria1' => $c1,
                    'kriteria2' => $c2,
                    'value' => $pairwiseValues[$c1->id][$c2->id] ?? 1, // default 1 jika belum ada
                ];
            }
        }

        // Ambil bobot jika sudah pernah dihitung
        $weights = DB::table('criteria_weights')
            ->where('session_id', $sessionId)
            ->where('user_id', $userId)
            ->get();

        return view('weight', compact('pairwiseComparisons', 'sessionId', 'weights'));
    }

    
    public function alternative($sessionId): View
    {
        $session = DssSession::findOrFail($sessionId);

        // Cek apakah session ini milik user yang sedang login
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        $criteria = Criteria::all();

        $alternatives = Alternative::where('session_id', $sessionId)
            ->with(['grades.criteria'])
            ->get();

        $rankings = RankingResult::with('alternative')->whereIn('id_alternative', $alternatives->pluck('id'))
        ->orderBy('rank')
        ->get();

        return view('alternative.index', [
            'session_id' => $sessionId,
            'alternatives' => $alternatives,
            'criteria' => $criteria,
            'rankings' => $rankings
        ]);
    }
}
