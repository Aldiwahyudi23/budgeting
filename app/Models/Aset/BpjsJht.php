<?php

namespace App\Models\Aset;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BpjsJht extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_contribution',
        'employee_contribution',
        'initial_balance',
        'final_balance',
        'transaction_date',
        'status',
        'reference_number',
        'description',
    ];
}