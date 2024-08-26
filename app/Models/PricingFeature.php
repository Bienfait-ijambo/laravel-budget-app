<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingFeature extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'priceId'];

    public function price()
    {
        $this->hasMany(Pricing::class, 'id');
    }
}
