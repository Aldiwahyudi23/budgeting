<?php

namespace App\Models\Aktivitas;

use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'category_id',
        'sub_kategori_id',
        'payment',
        'account_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_kategori_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function accountBank()
    {
        return $this->belongsTo(AccountBank::class, 'account_id');
    }
}