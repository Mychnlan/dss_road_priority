<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeCriteria extends Model
{
    use HasFactory;

    protected $table = 'grade_criteria';

    protected $fillable = [
        'id_alternative',
        'id_criteria',
        'grade',
    ];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class, 'id_alternative');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'id_criteria');
    }
}
