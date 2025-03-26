<?php

namespace App\Models\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job';
    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'job_description',
        'salary',
        'bpjs',
        'bpjs_company_percentage',
        'bpjs_employee_percentage',
        'benefits',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}