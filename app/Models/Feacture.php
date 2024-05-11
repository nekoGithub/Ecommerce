<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feacture extends Model
{
    use HasFactory;

    protected $fillable = ['value','description','option_id'];

    //Relacion de uno a muchos inversa
    public function option(){
        return $this->belongsTo(Option::class);
    }

    //Relacion de muchos a muchos
    public function variants(){
        return $this->belongsToMany(Variant::class)
                    ->withTimestamps();
    }
}
