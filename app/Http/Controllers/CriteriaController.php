<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function apiIndex()
    {
        $criteria = Criteria::all()->map(function ($c) {
            return [
                'id' => $c->id,
                'nama' => $c->name_criteria,
                'jenis' => $c->type,
                'bobot' => $c->weight,
            ];
        });

        return response()->json($criteria);
    }
    
}
