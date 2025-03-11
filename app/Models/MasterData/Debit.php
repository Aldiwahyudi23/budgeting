<?php

namespace App\Models\MasterData;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'note',
        'amount',
        'balance',
    ];
    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}