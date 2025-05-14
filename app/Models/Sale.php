<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'produit_id',
        'date',
    ];

    public function vendeur() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produit() {
        return $this->belongsTo(Product::class);
    }
}
