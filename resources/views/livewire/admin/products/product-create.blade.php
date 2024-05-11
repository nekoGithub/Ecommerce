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
            src="{{ $image ? $image->temporaryUrl() : asset('img/Image_not_available.png') }}"
            alt="">
        </figure>

        <x-validation-errors class="mb-4"/>

        <div class="card">
            <div class="mb-4">
                <x-label class="mb-2">
                    Codigo
                </x-label>
                <x-input wire:model="product.sku" class="w-full" placeholder="Ingrese el codigo del producto..."/>
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Nombre
                </x-label>
                <x-input wire:model="product.name" class="w-full" placeholder="Ingrese el nombre del producto aqui..."/>
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Descripcion
                </x-label>
                <x-textarea wire:model="product.description" class="w-full" placeholder="Ingrese la descripcion del producto aqui..." />
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
                <x-select class="w-full" wire:model="product.subcategory_id">
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
                wire:model="product.price"
                class="w-full"
                placeholder="Ingrese el precio del producto aqui...."/>
        </div>

        <div class="flex justify-end">
            <x-button>
                Crear producto
            </x-button>
        </div>
    </form>
</div>
