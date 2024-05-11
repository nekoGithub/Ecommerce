<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['sku','image_path','stock','product_id'];


    // creando un accessor
    public function image(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->image_path ? Storage::url($this->image_path) : asset('img/noimage.jpg'),
        );
    }
    //Relacion de uno a muchos inversa
    public function product(){
        return $this->belongsTo(Product::class);
    }

    //Relacion de muchos a muchos
    public function feactures(){
        return $this->belongsToMany(Feacture::class)
                    ->withTimestamps();
    }
}
