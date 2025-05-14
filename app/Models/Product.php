<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nom',
        'quantite',
        'marque',
        'prix',
        'couleur',
        'config',
        'description',
        'image',
        'categorie_id',
    ];

    public function categorie() {
        return $this->belongsTo(Category::class);
    }

    public function ventes() {
        return $this->hasMany(Sale::class);
    }
}
