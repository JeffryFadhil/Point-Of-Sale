<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [
        'name_product',
        'harga_jual',
        'harga_beli_pokok',
        'kategori_id',
        'stok',
        'stok_minimal',
        'is_active',
        'Sku',
    ];
    public static function nomorSku(){
        $prefix = 'SKU-';
        $maxId = self::max('id');
        $sku = $prefix . str_pad($maxId + 1 , 5, '0', STR_PAD_LEFT);
        return $sku;
    }
    use HasFactory;
}
