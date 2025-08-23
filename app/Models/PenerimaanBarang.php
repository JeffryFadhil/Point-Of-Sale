<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Guard;

class PenerimaanBarang extends Model
{
    protected $guarded = ['id']; 
    use HasFactory;

    public static function nomorPenerimaan()
    {
        $max = self::max('id');
        $prefix = 'PBR-';
        $date = date('dmy');
        $number = $prefix . $date . str_pad($max + 1, 4, '0', STR_PAD_LEFT);
        return $number;
    }
    public function items(){
        return $this->hasMany(itemPenerimaanBarang::class, 'nomor_penerimaan', 'nomor_penerimaan');
    }
}
