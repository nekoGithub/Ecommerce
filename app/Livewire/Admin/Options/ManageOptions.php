<?php

namespace App\Livewire\Admin\Options;

use App\Livewire\Forms\admin\options\NewOptionForm;
use App\Models\Feacture;
use App\Models\Option;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageOptions extends Component
{
    public $options;

    public NewOptionForm $newOption;

    public function mount(){
        $this->options = Option::with('feactures')->get();
    }

    public function addFeacture(){
        $this->newOption->addFeacture();
    }

    public function deleteFeacture(Feacture $feacture){
        $feacture->delete();

        $this->options = Option::with('feactures')->get();
    }

    public function deleteOption(Option $option){
        $option->delete();
        $this->options = Option::with('feactures')->get();
    }

    public function removeFeacture($index){
        $this->newOption->removeFeacture($index);
    }

    #[On('feactureAdded')]
    public function updateOptionList(){
        $this->options = Option::with('feactures')->get();
    }

    public function addOption(){

        $this->newOption->save();

        $this->options = Option::with('feactures')->get();

        /* $this->reset('openModal','newOption'); */

        $this->dispatch('swal',[
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La opcion se agrego correctamente.'
        ]);
    }

    public function render()
    {

        return view('livewire.admin.options.manage-options');
    }
}
