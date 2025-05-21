<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DssSession extends Model
{
    use HasFactory;

    protected $table = 'dss_sessions';

    protected $fillable = [
        'name_session',
        'user_id',
    ];
}
