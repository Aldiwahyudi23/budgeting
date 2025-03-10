<?php

namespace App\Models\MasterData;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'is_active'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subSource()
    {
        return $this->hasMany(SubSource::class);
    }
}
