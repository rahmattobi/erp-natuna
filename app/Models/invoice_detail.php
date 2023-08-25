<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class invoice_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'kuantitas',
        'harga',
        'no_inv',
        'tanggal',
        'keterangan',
        'tempo'
    ];

    public function invoice()
    {
        return $this->belongsTo(invoice::class);
    }
}
