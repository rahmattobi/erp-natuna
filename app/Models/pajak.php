<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pajak extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_invoice',
        'ntpn',
    ];
}
