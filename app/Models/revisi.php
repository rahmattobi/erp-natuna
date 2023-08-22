<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class revisi extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'revisi',
    ];

    public function invoice()
    {
        return $this->belongsTo(invoice::class);
    }
}
