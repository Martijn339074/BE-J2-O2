<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Product';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function magazine()
    {
        return $this->hasOne(Magazine::class, 'ProductId');
    }

    public function allergens()
    {
        return $this->belongsToMany(Allergen::class, 'ProductPerAllergeen', 'ProductId', 'AllergeenId');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'ProductPerLeverancier', 'ProductId', 'LeverancierId')
                    ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
    }
}

class Magazine extends Model
{
    use HasFactory;

    protected $table = 'Magazijn';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId');
    }
}

class Allergen extends Model
{
    use HasFactory;

    protected $table = 'Allergeen';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ProductPerAllergeen', 'AllergeenId', 'ProductId');
    }
}