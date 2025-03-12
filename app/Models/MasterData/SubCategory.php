<?php

namespace App\Models\MasterData;

use App\Models\Financial\Bill;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke Bill
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
