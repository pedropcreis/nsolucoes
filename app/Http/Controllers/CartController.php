<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index() {

        $cart_items = Cart::join('products', 'cart.product_id', '=', 'products.id')->where('cart.user_id', Auth::user()->id)->select('cart.*', 'products.name', 'products.image')->get();

        return view('cart.index', ['cart_items' => $cart_items]);

    }

    public function addToCart(Request $request) {
        try {

            DB::beginTransaction();

            $cart = new Cart();

            $cart->user_id = Auth::user()->id;
            $cart->product_id = $request->product_id;
            $cart->quantity = $request->quantity;
            $cart->unit_price = $request->unit_price;

            $cart->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Produto adicionado ao carrinho.'
            ]);

        } catch(\Exception $e) {

            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Houve um erro inesperado. Tente novamente.',
                'verbose' => $e,
            ]);

        }
    }
}
