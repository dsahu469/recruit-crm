<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $table = 'skill_t';

    protected $primaryKey = 'id';
    public $incrementing  = false;
    protected $keyType = 'string';

    protected $fillable = [
        'candidate_id', // Add other attributes here as well
        'skill',
        'level'
    ];
}
