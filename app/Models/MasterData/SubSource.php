<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSource extends Model
{
    use HasFactory;

    protected $fillable = ['source_id', 'name', 'description', 'is_active', 'public'];

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}