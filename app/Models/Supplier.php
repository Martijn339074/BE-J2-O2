<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'Leverancier';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ProductPerLeverancier', 'LeverancierId', 'ProductId')
                    ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
    }

    // Accessor to get the number of unique products for each supplier
    public function getProductCountAttribute()
    {
        return $this->products()->distinct('ProductId')->count();
    }
}