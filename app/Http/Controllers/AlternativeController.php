<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\GradeCriteria;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    public function store(Request $request, $session)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'grades' => 'required|array',
        ]);

        // Simpan ke tabel alternatives
        $alternative = Alternative::create([
            'session_id' => $session, // ambil langsung dari parameter
            'name_alternative' => $request->name,
        ]);

        // Ambil semua criteria
        $criteria = Criteria::all();

        // Simpan ke grade_criteria
        foreach ($criteria as $index => $criterion) {
            GradeCriteria::create([
                'id_alternative' => $alternative->id,
                'id_criteria' => $criterion->id,
                'grade' => $request->grades[$index],
            ]);
        }

        return redirect()->back()->with('success', 'Alternatif berhasil ditambahkan');
    }
}
