<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class SaleController extends Controller
{

    public function index() {
        return view('sales.index');
    }

    public function list() {

        /*
        PAYMENT_TYPE_IDS:
            account_money: Conta do Mercado Pago.
            ticket: Boleto.
            bank_transfer: Pix.
            credit_card: Cartão de crédito.
            debit_card: Cartão de débito.
        */

        $sales = DB::table('sales')
        ->join('users', 'sales.user_id', '=', 'users.id')
        ->join('transactions', 'sales.id', '=', 'transactions.sale_id')->where('transactions.status', '=', 'approved')
        ->select('sales.*', 'users.name AS user_name', DB::raw("
            CASE WHEN transactions.payment_type_id = 'account_money' THEN 'Mercado Pago'
            WHEN transactions.payment_type_id = 'ticket' THEN 'Boleto'
            WHEN transactions.payment_type_id = 'bank_transfer' THEN 'PIX'
            WHEN transactions.payment_type_id = 'credit_card' THEN 'Cartão de crédito'
            WHEN transactions.payment_type_id = 'debit_card' THEN 'Cartão de débito'
            ELSE 'Não identificado' END AS payment_type_id
        "), DB::raw("sales.items_total + sales.shipment_total AS total"), DB::raw('DATE_FORMAT(sales.created_at, "%d/%m/%Y %H:%i") AS date'))->orderBy('sales.id', 'DESC');
        return DataTables::of($sales)->make(true);
    }
    
    public function store(Request $request) {
        try {

            $cart_total = DB::table('cart')->where('user_id', Auth::user()->id)->sum(DB::raw('unit_price * quantity'));
            $cart_items = Cart::join('products', 'cart.product_id', '=', 'products.id')->where('user_id', Auth::user()->id)->select('cart.*', 'products.name')->get();

            DB::beginTransaction();

            $sale = new Sale();

            $sale->user_id = Auth::user()->id;
            $sale->items_total = $cart_total;
            $sale->shipment_total = (float) $request->shipment_total;

            $sale->save();

            \MercadoPago\SDK::setAccessToken('TEST-6126144999769461-072808-2ea38a3340203f779db0a4f3ca000d6e-411133990');
            $preference = new \MercadoPago\Preference();

            if($sale->id) {
                $products_arr = array();
                foreach($cart_items as $item) {
                    $sale_item = new SaleItem();

                    $sale_item->sale_id = $sale->id;
                    $sale_item->product_id = $item->product_id;
                    $sale_item->quantity = (float) $item->quantity;
                    $sale_item->unit_price = (float) $item->unit_price;

                    $sale_item->save();

                    $mp_item = new \MercadoPago\Item();
                    $mp_item->title = $item->name;
                    $mp_item->quantity = (float) $item->quantity;
                    $mp_item->unit_price = (float) $item->unit_price;
                    
                    $products_arr[] = $mp_item;
                }

                $preference->items = $products_arr;

                $shipments = new \MercadoPago\Shipments();
                $shipments->cost = (float) $request->shipment_total;
                $shipments->mode = 'not_specified';
                $preference->external_reference = $sale->id; // id da televenda
                $preference->shipments = $shipments;

            }

            $preference->payment_methods = array(
                "excluded_payment_types" => array(
                    array("id" => "ticket"),
                    array("id" => "debit_card"),
                ),
                "installments" => 1
            );

            $preference->back_urls = array(
                'success' => 'https://testensolucoes.inforservice.com.br/handle-payment',
                'failure' => 'https://testensolucoes.inforservice.com.br/cart',
                'pending' => 'https://testensolucoes.inforservice.com.br/handle-payment',
            );

            $preference->auto_return = 'approved';
            $preference->save();
            
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pedido salvo.',
                'preference_id' => $preference->id
            ]);

        } catch(\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Houve um erro inesperado. Tente novamente.',
                'verbose' => $err,
            ]);
        }
    }

}
