<?php

namespace App\Models\Alokasi;

use App\Models\MasterData\Source;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'source_id',
        'amount',
        'date',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel categories
    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}