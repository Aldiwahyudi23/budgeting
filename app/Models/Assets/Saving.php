<?php

namespace App\Models\Assets;

use App\Models\MasterData\Category;
use App\Models\MasterData\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'note',
        'category_id',
        'sub_category_id',
        'balance',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke tabel sub_categories
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}