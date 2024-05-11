<div>
    <form wire:submit="addFeacture" class="flex space-x-5">
        <div class="flex-1">
            <x-label class="mb-2">
                Valor
            </x-label>

            @switch($option->type)
                @case(1)
                    <x-input
                        wire:model="newFeacture.value"
                        class="w-full "
                        placeholder="Ingrese el valor de la opcion"/>

                    @break
                @case(2)
                    <div class="border border-gray-300 rounded-md h-[42px] flex items-center justify-between px-3">
                        {{
                            $newFeacture['value'] ?: 'Seleccione un color'
                        }}
                        <input type="color"
                            wire:model.live="newFeacture.value">
                    </div>
                    @break

                @default

            @endswitch
        </div>
        <div class="flex-1">
            <x-label class="mb-2">
                Descripcion
            </x-label>
            <x-input
                wire:model="newFeacture.description"
                class="w-full"
                placeholder="Ingrese una descripcion "/>
        </div>
        <div class="pt-8">
            <x-button>
                Agergar
            </x-button>
        </div>
    </form>
</div>
