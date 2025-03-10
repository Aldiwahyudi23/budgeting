<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'btn_edit',
        'btn_delete',
        'expense_saving',
        'saving_expense',
        'income_saving',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
