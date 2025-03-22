<?php

namespace App\Models;

use App\Models\MasterData\AccountBank;
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
        'account_id',
        'bank',
        'cash',
        'date_in',
        'date_ex',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function accountBank()
    {
        return $this->belongsTo(AccountBank::class);
    }
}