<?php

namespace App\Models\MasterData;

use App\Models\Financial\Bill;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AccountBank extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'type',
        'name',
        'description',
        'is_active',
        'amount',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Kolom yang akan dicatat perubahannya
    protected static $logAttributes = [
        'user_id',
        'type',
        'name',
        'description',
        'is_active',
        'amount',
    ];

    // Opsi tambahan
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'user_id',
                'type',
                'name',
                'description',
                'is_active',
                'amount',
            ])
            ->logOnlyDirty() // Hanya catat kolom yang berubah
            ->setDescriptionForEvent(fn(string $eventName) => "User has been {$eventName}");
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}