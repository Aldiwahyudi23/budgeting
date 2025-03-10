<?php

namespace App\Models\Aktivitas;

use App\Models\MasterData\AccountBank;
use App\Models\MasterData\Source;
use App\Models\MasterData\SubSource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'source_id',
        'sub_source_id',
        'payment',
        'account_id',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function subSource()
    {
        return $this->belongsTo(SubSource::class, 'sub_source_id');
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