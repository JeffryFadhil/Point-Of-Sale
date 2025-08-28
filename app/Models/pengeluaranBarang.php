<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Guard;


class pengeluaranBarang extends Model
{
    protected $guarded = ['id'];
    public static function nomorPengeluaran()
    {
        $max = self::max('id');
        $prefix = 'TRX-';
        $date = date('dmy');
        $number = $prefix . $date . str_pad($max + 1, 4, '0', STR_PAD_LEFT);
        return $number;
    }
     public function items(){
        return $this->hasMany(itemPengeluaranBarang::class, 'nomor_pengeluaran', 'nomor_pengeluaran');
    }


    use HasFactory;
}
