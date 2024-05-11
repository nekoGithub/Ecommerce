<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name','category_id'];

    //Relacion de uno muchos inversa
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // Relacion d euno muchos
    public function products(){
        return $this->hasMany(Product::class);
    }
}
