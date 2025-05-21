<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criteria';

    protected $fillable = [
        'name_criteria',
        'type',
        'weight',
    ];

    public function grades()
    {
        return $this->hasMany(GradeCriteria::class, 'id_criteria');
    }
}
