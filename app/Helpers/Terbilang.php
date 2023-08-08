<?php

namespace App\Helpers;

function Terbilang($number)
{
    $words = [
        0 => 'Nol',
        1 => 'Satu',
        2 => 'Dua',
        3 => 'Tiga',
        4 => 'Empat',
        5 => 'Lima',
        6 => 'Enam',
        7 => 'Tujuh',
        8 => 'Delapan',
        9 => 'Sembilan',
        10 => 'Sepuluh',
        11 => 'Sebelas',
    ];

    if ($number < 12) {
        return $words[$number];
    } elseif ($number < 20) {
        return terbilang($number - 10) . ' Belas';
    } elseif ($number < 100) {
        return terbilang(floor($number / 10)) . ' Puluh ' . terbilang($number % 10);
    } elseif ($number < 200) {
        return 'seratus ' . terbilang($number - 100);
    } elseif ($number < 1000) {
        return terbilang(floor($number / 100)) . ' Ratus ' . terbilang($number % 100);
    } elseif ($number < 2000) {
        return 'seribu ' . terbilang($number - 1000);
    } elseif ($number < 1000000) {
        return terbilang(floor($number / 1000)) . ' Ribu ' . terbilang($number % 1000);
    } elseif ($number < 1000000000) {
        return terbilang(floor($number / 1000000)) . ' Juta ' . terbilang($number % 1000000);
    } else {
        return 'undefined';
    }
}
