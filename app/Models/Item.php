<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'price'
    ];

    public function Properties()
    {
        return $this->hasMany(Property::class);
    }
}
