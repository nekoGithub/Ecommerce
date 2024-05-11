<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feacture;
use App\Models\Option;
use App\Models\Variant;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductVariants extends Component
{

    public $product;

    public $openModal = false;

    public $options;

    public $variant = [
        'option_id' => '',
        'feactures' => [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ]
        ],
    ];

    public function mount(){
        $this->options = Option::all();
    }

    public function updatedVariantOptionId(){
        $this->variant['feactures'] = [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ]
        ];
    }

    #[Computed()]
    public function feactures(){
        return Feacture::where('option_id', $this->variant['option_id'])->get();
    }

    public function addFeacture(){
        $this->variant['feactures'][] = [
            'id' => '',
            'value' => '',
            'description' => '',
        ];
    }

    public function removeFeacture($index){
        unset($this->variant['feactures'][$index]);
        $this->variant['feactures'] = array_values($this->variant['feactures']);
    }

    public function feacture_change($index){
        $feacture = Feacture::find($this->variant['feactures'][$index]['id']);

        if ($feacture) {
            $this->variant['feactures'][$index]['value'] = $feacture->value;
            $this->variant['feactures'][$index]['description'] = $feacture->description;
        }
    }

    public function save(){

        $this->validate([
            'variant.option_id' => 'required',
            'variant.feactures.*.id' => 'required',
            'variant.feactures.*.value' => 'required',
            'variant.feactures.*.description' => 'required',
        ]);

        $this->product->options()->attach($this->variant['option_id'],['feactures' => $this->variant['feactures']]);

        $this->product = $this->product->fresh();

        $this->generarVariantes();

        $this->reset(['variant','openModal']);
    }

    public function deleteFeacture($option_id, $feacture_id){
        $this->product->options()->updateExistingPivot($option_id,[
            'feactures' => array_filter($this->product->options->find($option_id)->pivot->feactures, function ($feacture) use ($feacture_id){
                return $feacture['id'] != $feacture_id;
            })
        ]);

        $this->product = $this->product->fresh();

        $this->generarVariantes();
    }

    public function deleteOption($option_id){
        $this->product->options()->detach($option_id);
        $this->product = $this->product->fresh();

        $this->generarVariantes();
    }

    public function generarVariantes(){
        $feactures = $this->product->options->pluck('pivot.feactures');
        $combinaciones = $this->generarCombinaciones($feactures);
        $this->product->variants()->delete();

        foreach ($combinaciones as $combianacion) {
            $variant = Variant::create([
                'product_id' => $this->product->id,
            ]);

            $variant->feactures()->attach($combianacion);
        }

        $this->dispatch('variant-generate');

    }

    function generarCombinaciones($arrays, $indice = 0,$combianacion = []){

        if ($indice == count($arrays)) {
            return [$combianacion];
        }

        $resultado = [];

        foreach ($arrays[$indice] as $item) {
            $combianacionTemporal = $combianacion;
            $combianacionTemporal[] = $item['id'];

            $resultado = array_merge($resultado,$this->generarCombinaciones($arrays,$indice + 1, $combianacionTemporal));
        }

        return $resultado;

    }


    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }
}

