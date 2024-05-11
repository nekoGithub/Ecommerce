<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WelcomeController;
use App\Models\Product;
use App\Models\Variant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Route::get('families/{family}',[FamilyController::class, 'show'])->name('families.show');

Route::get('categories/{category}',[CategoryController::class, 'show'])->name('categories.show');

Route::get('subcategories/{subcategory}',[SubcategoryController::class, 'show'])->name('subcategories.show');

Route::get('products/{product}',[ProductController::class, 'show'])->name('products.show');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('shipping',[ShippingController::class, 'index'])->name('shipping.index');

Route::get('checkout',[CheckoutController::class, 'index'])->name('checkout.index');

Route::post('checkout/paid',[CheckoutController::class, 'paid'])->name('checkout.paid');

Route::get('gracias',function(){
    return view('gracias');
})->name('gracias');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('prueba', function(){
    Cart::instance('shopping');
    return Cart::content();
});

/* Route::get('prueba', function () {

    $product = Product::find(150);

    $feactures = $product->options->pluck('pivot.feactures');

    $combinaciones = generarCombinaciones($feactures);

    $product->variants()->delete();

    foreach ($combinaciones as $combianacion) {
        $variant = Variant::create([
            'product_id' => $product->id,
        ]);

        $variant->feactures()->attach($combianacion);
    }
    return "Variantes creadas";
}); */

/* function generarCombinaciones($arrays, $indice = 0,$combianacion = []){

    if ($indice == count($arrays)) {
        return [$combianacion];
    }

    $resultado = [];

    foreach ($arrays[$indice] as $item) {
        $combianacionTemporal = $combianacion;
        $combianacionTemporal[] = $item['id'];

        $resultado = array_merge($resultado,generarCombinaciones($arrays,$indice + 1, $combianacionTemporal));
    }

    return $resultado;

} */
