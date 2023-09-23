<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\SaleItem;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MercadoPagoController extends Controller
{

    public function webhooks(Request $request) {
        try {
            $payment_id = $request['data']['id'];
            $client = new Client;
            $response = $client->get("https://api.mercadopago.com/v1/payments/" . $payment_id . "?access_token=TEST-6126144999769461-072808-2ea38a3340203f779db0a4f3ca000d6e-411133990");
            $response = json_decode($response->getBody()->getContents());

            $status = $response->status;
            $status_detail = $response->status_detail;

            $status_message = $this->getPaymentStatusInfo($status);
            $status_detail_message = $this->getPaymentStatusDetailInfo($status_detail);

            $sale = Sale::select('user_id')->where('id', '=', $response->external_reference)->get()->first();
            $transaction = Transaction::select('id')->where('transaction_id', '=', $payment_id)->get();
            if(count($transaction) > 0) {
                Transaction::where('transaction_id', '=', $payment_id)->update([
                    'status' => $status,
                    'status_message' => $status_message,
                    'status_detail' => $status_detail,
                    'status_detail_message' => $status_detail_message,
                    'payment_method_id' => $response->payment_method_id,
                    'payment_type_id' => $response->payment_type_id,
                    'installments' => $response->installments,
                    'total_value' => $response->transaction_details->total_paid_amount,
                    'received_value_mercadopago' => $response->transaction_details->net_received_amount,
                    'tax_value_mercadopago' => count($response->fee_details) > 0 ? $response->fee_details[0]->amount : 0
                ]);
            } else {
                Transaction::create([
                    'sale_id' => $response->external_reference,
                    'transaction_id' => $payment_id,
                    'status' => $status,
                    'status_message' => $status_message,
                    'status_detail' => $status_detail,
                    'status_detail_message' => $status_detail_message,
                    'payment_method_id' => $response->payment_method_id,
                    'payment_type_id' => $response->payment_type_id,
                    'installments' => $response->installments,
                    'total_value' => $response->transaction_details->total_paid_amount,
                    'received_value_mercadopago' => $response->transaction_details->net_received_amount,
                    'tax_value_mercadopago' => count($response->fee_details) > 0 ? $response->fee_details[0]->amount : 0
                ]);
            }
            if($status == 'approved') {
                Sale::where('id', '=', $response->external_reference)->update([
                    'transaction_status' => 1,
                ]);

                Cart::where('user_id', $sale->user_id)->delete();
            }

            return response('success', 200);
        } catch(Exception $err) {
            return response($err->getMessage(), 400);
        }
    }

    public function handlePayment(Request $request) {
        try {
            $qr_code = null;
            $qr_code_base64 = null;

            $client = new Client;
            $response = $client->get("https://api.mercadopago.com/v1/payments/" . $request['payment_id'] . "?access_token=TEST-6126144999769461-072808-2ea38a3340203f779db0a4f3ca000d6e-411133990");
            $response = json_decode($response->getBody()->getContents());

            if($response->status != 'rejected' && $response->payment_type_id == 'bank_transfer') {
                $qr_code = $response->point_of_interaction->transaction_data->qr_code;
                $qr_code_base64 = $response->point_of_interaction->transaction_data->qr_code_base64;
            }
                
            $status_message = $this->getPaymentStatusInfo($response->status);
            $sale = Sale::select('user_id')->where('id', '=', $response->external_reference)->get()->first();
            $transaction = Transaction::select('id')->where('transaction_id', '=', $request['payment_id'])->get();

            if(count($transaction) > 0) {
                Transaction::where('transaction_id', '=', $request['payment_id'])->update([
                    'status' => $response->status,
                    'status_message' => $status_message,
                    'payment_type_id' => $response->payment_type_id,
                    'qr_code' => $qr_code,
                    'qr_code_base64' => $qr_code_base64,
                ]);
            } else {
                Transaction::create([
                    'sale_id' => $response->external_reference,
                    'status' => $response->status,
                    'status_message' => $status_message,
                    'transaction_id' => $request['payment_id'],
                    'payment_type_id' => $response->payment_type_id,
                    'qr_code' => $qr_code,
                    'qr_code_base64' => $qr_code_base64,
                ]);
            }

            # Detalhamento do pedido
            $order = Sale::leftJoin('transactions', 'transactions.sale_id', '=', 'sales.id')->where('sales.user_id', '=', $sale->user_id)->where('sales.id', '=', $request['external_reference'])->select('sales.*', 'transactions.status_message')->first();

            # Produtos do pedido
            $order_items = SaleItem::select('products.name', 'products.image', 'sale_items.*')
                ->leftJoin('products', 'products.id', '=', 'sale_items.product_id')
                ->where('sale_id', '=', $request['external_reference'])->get();

            Cart::where('user_id', $sale->user_id)->delete();

            return view('orders.index', [
                'order' => $order,
                'id' => $request['external_reference'],
                'order_items' => $order_items,
            ]);
        } catch(Exception $err) {
            return response($err->getMessage(), 400);
        }
    }

    public function getPaymentStatusInfo($status) {
        $status_message = '';
        switch($status) {
            case 'pending': 
                $status_message = 'Aguardando pagamento.'; //The user has not yet completed the payment process.
                break;
            case 'approved':
                $status_message = 'Pagamento efetuado com sucesso.'; //The payment has been approved and accredited.
                break;
            case 'authorized': 
                $status_message = 'Pagamento autorizado, mas ainda não efetuado.'; //The payment has been authorized but not captured yet.
                break;
            case 'in_process': 
                $status_message = 'O pagamento está sendo revisado.'; //Payment is being reviewed.
                break;
            case 'in_mediation': 
                $status_message = 'O pagamento está em mediação.'; //Users have initiated a dispute.
                break;
            case 'rejected': 
                $status_message = 'Pagamento rejeitado.'; //Payment was rejected. The user may retry payment.
                break;
            case 'cancelled': 
                $status_message = 'O pagamento foi cancelado por uma das partes ou o tempo para o pagamento expirou.';
                //Payment was cancelled by one of the parties or because time for payment has expired
                break;
            case 'refunded': 
                $status_message = 'O pagamento foi reembolsado.'; //Payment was refunded to the user.
                break;
            case 'charged_back': 
                $status_message = 'Pagamento cancelado no cartão de crédito do comprador'; //A chargeback was made in the buyer’s credit card.
                break;
            default:
                $status_message = 'Não conseguimos encontrar o status do pagamento';
        }
        return $status_message;
    }

    public function getPaymentStatusDetailInfo($status_detail) {
        $status_detail_message = '';
        switch($status_detail) {
            case 'accredited': 
                $status_detail_message = 'Pagamento creditado.'; //credited payment.
                break;
            case 'pending_contingency': 
                $status_detail_message = 'O pagamento está sendo processado.'; //the payment is being processed.
                break;
            case 'pending_review_manual': 
                $status_detail_message = 'O pagamento está sendo revisado para determinar se será aprovado ou rejeitado.'; 
                //the payment is under review to determine its approval or rejection.
                break;
            case 'cc_rejected_bad_filled_date': 
                $status_detail_message = 'Data de expiração incorreta.'; //incorrect expiration date.
                break;
            case 'cc_rejected_bad_filled_other': 
                $status_detail_message = 'Dados do cartão incorretos.'; //incorrect card details.
                break;
            case 'cc_rejected_bad_filled_security_code': 
                $status_detail_message = 'CVV incorreto.'; //incorrect CVV.
                break;
            case 'cc_rejected_blacklist': 
                $status_detail_message = 'O cartão está em uma lista negra por conta de roubo, reclamações ou fraudes.'; 
                //the card is on a black list for theft/complaints/fraud.
                break;
            case 'cc_rejected_call_for_authorize': 
                $status_detail_message = 'O meio de pagamento requer autorização prévia.';
                //the means of payment requires prior authorization of the amount of the operation.
                break;
            case 'cc_rejected_card_disabled': 
                $status_detail_message = 'O cartão está inativo.'; //the card is inactive.
                break;
            case 'cc_rejected_duplicated_payment': 
                $status_detail_message = 'Transação duplicada.'; //transacción duplicada.
                break;
            case 'cc_rejected_high_risk': 
                $status_detail_message = 'Recusado por prevenção de fraude.'; //rechazo por Prevención de Fraude.
                break;
            case 'cc_rejected_insufficient_amount': 
                $status_detail_message = 'Quantia insuficiente.'; //insufficient amount.
                break;
            case 'cc_rejected_invalid_installments': 
                $status_detail_message = 'Quantidade de parcelas inválida.'; //invalid number of installments.
                break;
            case 'cc_rejected_max_attempts': 
                $status_detail_message = 'Número de tentativas esgotado.'; //exceeded maximum number of attempts.
                break;
            case 'cc_rejected_other_reason': 
                $status_detail_message = 'Houve um erro genérico. Tente novamente.'; //generic error.
                break;
            default:
            $status_detail_message = 'Não conseguimos encontrar o status detalhado do pagamento.';
        }
        return $status_detail_message;
    }
}
