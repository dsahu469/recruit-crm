<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $table = 'phone_number_t';

    protected $primaryKey = 'id';
    public $incrementing  = false;
    protected $keyType = 'string';

    protected $fillable = [
        'candidate_id', // Add other attributes here as well
        'type',
        'number'
    ];
}
