<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $table = 'alternatives';

    protected $fillable = [
        'session_id',
        'name_alternative',
    ];

    public function grades()
    {
        return $this->hasMany(GradeCriteria::class, 'id_alternative');
    }

    public function session()
    {
        return $this->belongsTo(DssSession::class, 'session_id');
    }

    public function ranking()
    {
        return $this->hasOne(RankingResult::class, 'id_alternative');
    }
}
