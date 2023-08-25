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
        'inst_plan',
    ];

    public function invoiceDetail()
    {
        return $this->hasMany(invoice_detail::class);
    }

    public function revisions()
{
    return $this->hasMany(revisi::class);
}
}
