<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'SubCategorias',
        'route' => route('admin.subcategories.index')
    ],
    [
        'name' => $subcategory->name,

    ],

]">

@livewire('admin.subcategories.subcategory-edit', ['subcategory' => $subcategory])

</x-admin-layout>
