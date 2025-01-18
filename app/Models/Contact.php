<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'Contact';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Straat',
        'Huisnummer',
        'Postcode',
        'Stad'
    ];

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'ContactId');
    }
}