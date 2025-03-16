<?php

namespace App\Models\Financial;

use App\Models\MasterData\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
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
        'type',
        'due_date',
        'tenor_months',
        'last_payment_month',
        'reminder',
    ];

    protected $casts = [
        'amount' => 'decimal:0',
        'paid_amount' => 'decimal:0',
        'due_date' => 'integer',
        'tenor_months' => 'integer',
        'last_payment_month' => 'date',
        'reminder' => 'boolean',
    ];

    /**
     * Relasi ke User (pemilik hutang)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke SubCategory (kategori hutang)
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    /**
     * Cek apakah hutang sudah lunas
     */
    public function getIsPaidAttribute(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Cek apakah hutang sudah lewat jatuh tempo
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'overdue';
    }

    /**
     * Cek apakah hutang masih aktif
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }
}