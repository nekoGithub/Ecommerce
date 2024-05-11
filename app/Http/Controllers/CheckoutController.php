<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index(){
        $access_token = $this->generateAccessToken();
        $session_token = $this->generateSessionToken($access_token);


        return view('checkout.index',compact('session_token'));
    }

    public function generateAccessToken(){
        $url_api = config('services.niubiz.url_api') . '/api.security/v1/security';
        $user = config('services.niubiz.user');
        $password = config('services.niubiz.password');

        $auth = base64_encode($user. ':' .$password);
        return Http::withHeaders([
            'Authorization' => 'Basic ' . $auth,
        ])->get($url_api)->body();
    }

    public function generateSessionToken($access_token){
        $merchant_id = config('services.niubiz.merchant_id');
        $url_api = config('services.niubiz.url_api') . "/api.ecommerce/v2/ecommerce/token/session/{$merchant_id}";

        // esta parte del codigo esta instanciando el subtotal
        /* $convertir = Cart::instance('shopping')->subtotal(); */
        // esta parte del codigo esta conviertiendo de un valor 2,289.21 a 2289.21
        if(is_numeric($subtotal = floatval(str_replace(',','',Cart::instance('shopping')->subtotal())))){
            $subtotal = (float) str_replace(',', '', Cart::instance('shopping')->subtotal()) + 15;
        }else{
            $subtotal = "Error: El subtotal no es un valor numérico.";
        }

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'Content-Type' => 'application/json',
            ])->post($url_api, [
                'channel' => 'web',
                'amount' => $subtotal,
                'antifraud' => [
                    'clientIp' => request()->ip(),
                    'merchantDefineData' => [
                        'MDD15' => 'Valor MDD 15',
                        'MDD20' => 'Valor MDD 20',
                        'MDD33' => 'Valor MDD 33',
                    ],
                ],
            ])->json();
            return $response['sessionKey'];
    }

    public function paid(Request $request){
        $access_token = $this->generateAccessToken();

        $merchant_id = config('services.niubiz.merchant_id');

        $url_api = config('services.niubiz.url_api') . "/api.authorization/v3/authorization/ecommerce/{$merchant_id}";

        $response = Http::withHeaders([

            'Authorization' => $access_token,

            'Content-Type' => 'application/json',

        ])

            ->post($url_api, [

                'channel' => 'web',

                'captureType' => 'manual',

                'countable' => true,

                'order' => [

                    'tokenId' => $request->transactionToken,

                    'purchaseNumber' => $request->purchaseNumber,

                    'amount' => $request->amount,

                    'currency' => 'PEN',

                ],

            ])->json();

                /* return $response; */
        session()->flash('niubiz', [

            'response' => $response,

        ]);

        if (isset($response['dataMap']) && $response['dataMap']['ACTION_CODE'] == '000') {

            return redirect()->route('gracias');

        }
    }
}
