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

    protected $fillable = [
        'Naam',
        'ContactPersoon',
        'LeverancierNummer',
        'Mobiel',
        'ContactId'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'ContactId', 'Id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ProductPerLeverancier', 'LeverancierId', 'ProductId')
                    ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
    }

    public function getProductCountAttribute()
    {
        return $this->products()->distinct('ProductId')->count();
    }
}