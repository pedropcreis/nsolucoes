<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'transaction_id',
        'status',
        'status_message',
        'status_detail',
        'status_detail_message',
        'payment_method_id',
        'payment_type_id',
        'installments',
        'total_value',
        'received_value_mercadopago',
        'tax_value_mercadopago',
        'qr_code',
        'qr_code_base64'
    ];
}
