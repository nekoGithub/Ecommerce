<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['sku','name','description','image_path','price','stock','subcategory_id'];

    // refactorizando el codigo
    public function scopeVerifyFamily($query, $family_id){
        $query->when($family_id, function($query) use ($family_id){
            $query->whereHas('subcategory.category', function($query) use ($family_id){
                $query->where('family_id',$family_id);
            });
        });
    }

    public function scopeVerifyCategory($query, $category_id){
        $query->when($category_id, function($query) use ($category_id){
            $query->whereHas('subcategory',function($query) use ($category_id){
                $query->where('category_id',$category_id);
            });
        });
    }

    public function scopeVerifySubcategory($query, $subcategory_id){
        $query->when($subcategory_id, function($query) use ($subcategory_id){
            $query->where('subcategory_id', $subcategory_id);
        });
    }

    public function scopeCustomOrder($query, $orderBy){
        $query->when($orderBy == 1, function($query){
            $query->orderBy('created_at','desc');
        })
        ->when($orderBy == 2, function($query){
            $query->orderBy('price','desc');
        })
        ->when($orderBy == 3, function($query){
            $query->orderBy('price','asc');
        });
    }

    public function scopeSelectFeactures($query, $selected_feactures){
        $query->when($selected_feactures, function($query) use ($selected_feactures){
            $query->whereHas('variants.feactures',function($query) use ($selected_feactures){
                $query->whereIn('feactures.id',$selected_feactures);
            });
        });
    }

    public function scopeSearch($query, $search){
        $query->when($search, function($query) use ($search){
            $query->where('name','like','%'.$search.'%');
        });
    }


    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url($this->image_path),
        );
    }

    //Relacion de uno a muchos inversa
    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    //Relacion de uno a muchos
    public function variants(){
        return $this->hasMany(Variant::class);
    }

    //Relacion de muchos a muchos
    public function options(){
        return $this->belongsToMany(Option::class)
                    ->using(OptionProduct::class)
                    ->withPivot('feactures')
                    ->withTimestamps();
    }

}
