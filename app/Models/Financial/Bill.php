<?php

namespace App\Models\Financial;

use App\Models\MasterData\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'note',
        'sub_category_id',
        'reminder',
        'auto',
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
