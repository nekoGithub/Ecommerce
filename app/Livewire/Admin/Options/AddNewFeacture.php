<?php

namespace App\Livewire\Admin\Options;

use Livewire\Component;

class AddNewFeacture extends Component
{
    public $option;

    public $newFeacture =[
        'value' => '',
        'description' => '',
    ];

    public function addFeacture(){
        $this->validate([
            'newFeacture.value' => 'required',
            'newFeacture.description' => 'required',
        ]);
        $this->option->feactures()->create($this->newFeacture);

        $this->dispatch('feactureAdded');

        $this->reset('newFeacture');
    }

    public function render()
    {
        return view('livewire.admin.options.add-new-feacture');
    }
}
