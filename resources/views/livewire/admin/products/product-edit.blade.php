<div>
    <form wire:submit="store">
        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white cursor-pointer text-gray-700">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar Imagen
                    <input type="file" class="hidden" accept="image/*" wire:model="image">
                </label>
            </div>
            <img class="aspect-[16/9] object-cover object-center w-full"
            src="{{ $image ? $image->temporaryUrl() : Storage::url($productEdit['image_path']) }}"
            alt="">
        </figure>

        <x-validation-errors class="mb-4"/>

        <div class="card">
            <div class="mb-4">
                <x-label class="mb-2">
                    Codigo
                </x-label>
                <x-input wire:model="productEdit.sku" class="w-full" placeholder="Ingrese el codigo del producto..."/>
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Nombre
                </x-label>
                <x-input wire:model="productEdit.name" class="w-full" placeholder="Ingrese el nombre del producto aqui..."/>
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Descripcion
                </x-label>
                <x-textarea wire:model="productEdit.description" class="w-full" placeholder="Ingrese la descripcion del producto aqui..." />
            </div>
            <div class="mb-4">
                <x-label>
                    Familias
                </x-label>
                <x-select class="w-full" wire:model.live="family_id">

                    <option value="" disabled>
                        Seleccione una familia
                    </option>

                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">
                            {{ $family->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="mb-4">
                <x-label>
                    Categorias
                </x-label>
                <x-select class="w-full" wire:model.live="category_id">

                    <option value="" disabled>
                        Seleccione una categoria
                    </option>

                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Subcategorias
                </x-label>
                <x-select class="w-full" wire:model="productEdit.subcategory_id">
                    <option value="" disabled>
                        Seleeciona una Subcategoria
                    </option>
                    @foreach ($this->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">
                            {{ $subcategory->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </div>
        <div class="mb-4">
            <x-label class="mb-2">
                Precio
            </x-label>
            <x-input
                type="number"
                step="0.01"
                wire:model="productEdit.price"
                class="w-full"
                placeholder="Ingrese el precio del producto aqui...."/>
        </div>

        @empty($product->variants->count() > 0)

            <div class="mb-4">
                <x-label class="mb-2">
                    Stok
                </x-label>
                <x-input
                    type="number"
                    wire:model="productEdit.stock"
                    class="w-full"
                    placeholder="Ingrese el stock del producto aqui...."/>
            </div>
            
        @endempty

        <div class="flex justify-end">
            <x-danger-button onclick="confirmDelete()">
                Eliminar
            </x-danger-button>
            <x-button class="ml-2">
                Actualizar
            </x-button>
        </div>
    </form>

    <form action="{{ route('admin.products.destroy',$product) }}" method="POST" id="delete-form">
        @csrf
        @method('DELETE')
    </form>

    @push('js')
    <script>
        function confirmDelete(){
            Swal.fire({
                title: "¿Estas seguro?",
                text: "No podras revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Borralo!",
                cancelButtonText: "Cancelar",
                }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        }
    </script>
@endpush
</div>
