<?php

namespace App\Models\MasterData;

use App\Models\Aktivitas\Expenses;
use App\Models\Alokasi\AllocationEx;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'is_active', 'public'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subCategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function allocation()
    {
        return $this->hasOne(AllocationEx::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}