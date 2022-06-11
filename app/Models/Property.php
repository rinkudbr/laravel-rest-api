<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id','type'
    ];

    public function Items()
    {
        return $this->belongsTo(Item::class);
    }
}
