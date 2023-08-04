<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $table = 'experience_t';

    protected $primaryKey = 'id';
    public $incrementing  = false;
    protected $keyType = 'string';

    protected $fillable = [
        'candidate_id', // Add other attributes here as well
        'company',
        'title',
        'years'
    ];
}
