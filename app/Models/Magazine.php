<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;

    protected $table = 'Magazijn';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = ['ProductId', 'VerpakkingsEenheid', 'AantalAanwezig', 'LaatsteLevering'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }
}