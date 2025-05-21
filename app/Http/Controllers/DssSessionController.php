<?php

namespace App\Http\Controllers;

use App\Models\DssSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DssSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name_session' => 'required|string|max:255',
        ]);

        DssSession::create([
            'name_session' => $request->name_session,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Sesi berhasil ditambahkan.');
    }
}
