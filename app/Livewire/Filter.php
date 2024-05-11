<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Filter extends Component
{

    use WithPagination;

    public $family_id;
    public $category_id;
    public $subcategory_id;
    public $options;
    public $selected_feactures = [];
    public $orderBy = 1;

    public $search;

    public function mount(){

        $this->options = Option::verifyFamily($this->family_id)
        ->verifyCategory($this->category_id)
        ->verifySubcategory($this->subcategory_id)
        ->get()->toArray();

    }

    #[On('search')]
    public function search($search){
        $this->search = $search;
    }

    public function render()
    {

        $products = Product::verifyFamily($this->family_id)
        ->verifyCategory($this->category_id)
        ->verifySubcategory($this->subcategory_id)
        ->customOrder($this->orderBy)
        ->selectFeactures($this->selected_feactures)
        ->search($this->search)
        ->paginate(12);

        return view('livewire.filter',compact('products'));
    }
}
