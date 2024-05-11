<x-app-layout>
    <div class="max-w-xl mx-auto pt-12">
        <img class="w-full" src="https://i.pinimg.com/736x/30/27/bb/3027bb63aa7e82fe11e7268179820b70.jpg" alt="">
        @if (session('niubiz'))
            @php
                $response = session('niubiz')['response'];
            @endphp

            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 mt-8 dark:text-green-400" role="alert">
                <p class="mb-4">
                    {{ $response['dataMap']['ACTION_DESCRIPTION'] }}
                </p>
                <p>
                    <b>Numero de pedido: </b>
                    {{ $response['order']['purchaseNumber'] }}
                </p>
                <p>
                    <b>Fecha y hora del pedido: </b>
                    {{ now()->createFromFormat('ymdHis', $response['dataMap']['TRANSACTION_DATE'])->format('d-m-Y H:i:s') }}
                </p>
                <p>
                    <b>Tarjeta: </b>
                    {{ $response['dataMap']['CARD'] }} {{ ($response['dataMap']['BRAND']) }}
                </p>
                <p>
                    <b>Importe: </b>
                    {{ $response['order']['amount'] }} {{ $response['order']['currency'] }}
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
