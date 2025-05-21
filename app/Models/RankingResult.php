<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingResult extends Model
{
    protected $fillable = ['id_alternative', 'score', 'rank'];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class, 'id_alternative');
    }
}
