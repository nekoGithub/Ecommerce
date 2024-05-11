<x-app-layout>
    <div class="-mb-16 text-gray-700" x-data="{
        pago: 1,
    }">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="col-span-1">
                <div class="lg:max-w-[40rem] py-12 px-4 lg:pr-8 sm:pl-6 lg:pl-8 ml-auto">
                    <h1 class="text-2xl font-semibold mb-2">
                        Pago
                    </h1>
                    <div class="shadow rounded-lg overflow-hidden border border-gray-400">
                        <ul class="divide-y divide-gray-400">
                            <li>
                                <label class="p-4 flex items-center">
                                    <input x-model="pago" type="radio" value="1">
                                    <span class="ml-3">
                                        Tarjeta de debito / credito
                                    </span>
                                    <img class="h-6 ml-auto" src="https://codersfree.com/img/payments/credit-cards.png" alt="">
                                </label>
                                <div class="p-4 bg-gray-100 text-center border-t border-gray-400"
                                    x-show="pago == 1">
                                    <i class="fa-regular fa-credit-card text-9xl"></i>
                                    <p class="mt-2">
                                        Luego de hacer click al "Pagar ahora", se abrirá el checkout de Niudbiz para completar tu compra de formas segura.
                                    </p>
                                </div>
                            </li>
                            <li>
                                <label class="p-4 flex items-center">
                                    <input x-model="pago" type="radio" value="2">
                                    <span class="ml-3">
                                        Deposito Bancario o yape
                                    </span>
                                </label>
                                <div class="p-4 bg-gray-100 flex justify-center border-t border-gray-400"
                                    x-cloak
                                    x-show="pago == 2">
                                    <div>
                                        <p>1. Pago por deposito o transferencia bancaria:</p>
                                        <p>- BCP soles: 198-9876554421-98</p>
                                        <p>- CCI 002-198-2132132112</p>
                                        <p>- Razon social: Ecommerce S.A.C</p>
                                        <p>- RUC: 202393887327</p>
                                        <p>2. pago por YApe</p>
                                        <p>- Yape al numero 987 8899 213 (Ecommerce S.A.C)</p>
                                        <p>
                                            Enviar el comprobante de pago a 987 8899 213
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-span-1">
                <div class="lg:max-w-[40rem] py-12 px-4 lg:pl-8 sm:pr-6 lg:pr-8 mr-auto">
                    <ul class="space-y-4">
                        @foreach (Cart::instance('shopping')->content() as $item)
                            <li class="flex items-center space-x-4">
                                <div class="flex-shrink-0 relative">
                                    <img class="h-16 aspect-square" src="{{ $item->options->image }}" alt="">
                                    <div class="flex items-center justify-center h-6 w-6 bg-gray-900 bg-opacity-70 rounded-full absolute -right-2 -top-2">
                                        <span class="text-white font-semibold">
                                            {{ $item->qty }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p>
                                        {{ $item->name }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <p>Bs. {{ $item->price }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex justify-between">
                        <p>
                            Subtotal
                        </p>
                        <p>
                            Bs. {{ Cart::instance('shopping')->subtotal() }}
                        </p>
                    </div>
                    <div class="flex justify-between">
                        <p>
                            Precio de envio
                            <i class="fas fa-info-circle" title="El precio de envio es de Bs. 15"></i>
                        </p>
                        <p>
                            Bs. 15.00
                        </p>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between">
                        <p class="text-lg font-semibold">
                            Total
                        </p>
                        <p>
                            {{  is_numeric($subtotal = floatval(str_replace(',','',Cart::instance('shopping')->subtotal()))) ? "Bs. " . number_format(floatval($subtotal) + 15, 2) : "Error: El subtotal no es un valor numérico." }}
                        </p>
                    </div>
                    <div>
                        <button onclick=" VisanetCheckout.open()" class="btn btn-purple w-full">
                            Finalizar compra
                        </button>
                      {{--   <form action="paginaRespuesta" method="post">
                            <script
                              type="text/javascript"
                              src="https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true"
                              data-sessiontoken="{{ $session_token }}"
                              data-channel="web"
                              data-merchantid="{{config('services.niubiz.merchant_id') }}"
                              data-purchasenumber="2020100901"
                              data-amount="{{ str_replace(',','',Cart::instance('shopping')->subtotal()) }}"
                              data-expirationminutes="20"
                              data-timeouturl="about:blank"
                              data-merchantlogo="img/comercio.png"
                              data-formbuttoncolor="#000000"
                            ></script>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script type="text/javascript" src="https://static-content-qas.vnforapps.com/v2/js/checkout.js"> </script>

    <script type="text/javascript">

        document.addEventListener('DOMContentLoaded', function(){
            let purchasenumber = Math.floor(Math.random() * 1000000000);
            VisanetCheckout.configure({
                    sessiontoken:'{{ $session_token }}',
                    channel:'web',
                    merchantid:'{{config('services.niubiz.merchant_id') }}',
                    purchasenumber: purchasenumber,
                    amount: '{{ (float) str_replace(',', '', Cart::instance('shopping')->subtotal()) + 15 }}',
                    expirationminutes:'20',
                    timeouturl:'about:blank',
                    merchantlogo:'img/comercio.png',
                    formbuttoncolor:'#000000',
                    action: "{{route('checkout.paid')}}?amount="+{{ (float) str_replace(',', '', Cart::instance('shopping')->subtotal()) + 15 }} + "&purchaseNumber=" + purchasenumber,
                    complete: function(params) {
                    alert(JSON.stringify(params));
                    }
                });
        });

    </script>
    @endpush
</x-app-layout>
