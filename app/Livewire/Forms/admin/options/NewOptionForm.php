<?php

namespace App\Livewire\Forms\admin\options;

use App\Models\Option;
use Livewire\Attributes\Validate;
use Livewire\Form;

class NewOptionForm extends Form
{
    public $name;
    public $type = 1;
    public $feactures = [
        [
            'value' => '',
            'description' => '',
        ]
    ];
    public $openModal = false;

    public function rules(){
        $rules = [
            'name' => 'required',
            'type' => 'required|in:1,2',
            'feactures' => 'required|array|min:1',
        ];

        foreach ($this->feactures as $index => $feacture) {
            if ($this->type == 1) {
                $rules['feactures.'.$index.'.value'] ='required';
            }
            else {
                $rules['feactures.'.$index.'.value'] ='required|regex:/^#[a-f0-9]{6}$/i';
            }
            $rules['feactures.'.$index.'.description'] ='required|max:255';
        }

        return $rules;
    }

    public function validationAttributes(){
        $attributes = [
            'name' => 'nombre',
            'type' => 'tipo',
            'feactures' => 'valores',
        ];

        foreach ($this->feactures as $index => $feacture) {
            $attributes['feactures.'.$index.'.value'] = 'valor'.' '.($index + 1);
            $attributes['feactures.'.$index.'.description'] = 'descripcion'.' '.($index + 1);
        }

        return $attributes;
    }

    public function addFeacture(){
        $this->feactures[] = [
            'value' => '',
            'description' => '',
        ];
    }

    public function removeFeacture($index){
        unset($this->feactures[$index]);
        $this->feactures = array_values($this->feactures);
    }

    public function save(){
        $this->validate();

        $option = Option::create([
            'name' => $this->name,
            'type' => $this->type,
        ]);

        foreach ($this->feactures as $feacture) {
            $option->feactures()->create([
                'value' => $feacture['value'],
                'description' => $feacture['description'],
            ]);
        }

        $this->reset();
    }
}
