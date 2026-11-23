<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemotonganTercatat extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'bulan' => 'date',
    ];

    public function tempatPemotongan(): BelongsTo
    {
        return $this->belongsTo(TempatPemotongan::class, 'tempat_pemotongan_id');
    }
}
