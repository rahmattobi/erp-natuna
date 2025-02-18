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
        'keterangan',
    ];

    public function invoice()
    {
        return $this->belongsTo(invoice::class);
    }
}
