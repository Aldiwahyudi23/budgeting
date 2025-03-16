<?php

namespace App\Models\Financial;

use App\Models\MasterData\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'paid_amount',
        'status',
        'note',
        'sub_category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Model Bill
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}