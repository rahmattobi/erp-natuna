<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_client',
        'nama_perusahaan',
        'tanggal',
        'tempo',
        'no_inv',
        'inst_plan',
        'tempo',
    ];

    public function invoiceDetail()
    {
        return $this->hasMany(invoiceDetail::class);
    }
}
