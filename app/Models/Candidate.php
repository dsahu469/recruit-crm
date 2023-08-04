<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'candidate_t';

    protected $primaryKey = 'id';
    public $incrementing  = false;
    protected $keyType = 'string';

    protected $fillable = [
        'first_name', // Add other attributes here as well
        'last_name',
        'age',
        'department',
        'min_salary_expectation',
        'max_salary_expectation'
    ];
}
