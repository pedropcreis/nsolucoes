@extends('layouts.main')

@section('title', 'Pedido - ' . $id)

@section('content')

<div class="container">
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
            <h1 class="h2 text-uppercase mb-0">Pedido</h1>
            </div>
            <div class="col-lg-6 text-lg-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                <li class="breadcrumb-item"><a class="text-dark" href="/">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pedido</li>
                </ol>
            </nav>
            </div>
        </div>
        </div>
    </section>
    <section class="py-5">
        <h2 class="h5 text-uppercase mb-4">Pedido Nº {{ $id }}</h2>
        <h2 class="h5 text-uppercase mb-4" style="font-size: 12px;">Status do pagamento: <span style="font-weight: 400;">{{ $order->status_message }}</span></h2>
        <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <!-- CART TABLE-->
            <div class="table-responsive mb-4" style="height: 415px;">
            <table class="table text-nowrap">
                <thead class="bg-light">
                <tr>
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase">Produto</strong></th>
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase">Preço</strong></th>
                    <th class="border-0 p-3" scope="col" style="text-align: center;"> <strong class="text-sm text-uppercase">Quantidade</strong></th>
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase">Total</strong></th>
                </tr>
                </thead>
                <tbody class="border-0">
                    @foreach ($order_items as $item)
                        <tr>
                            <th class="ps-0 py-3 border-light" scope="row">
                            <div class="d-flex align-items-center"><a class="reset-anchor d-block animsition-link" href="detail.html"><img src="/img/uploads/{{ $item->image }}" alt="..." width="70"/></a>
                                <div class="ms-3"><strong class="h6"><a class="reset-anchor animsition-link" href="detail.html">{{ $item->name }}</a></strong></div>
                            </div>
                            </th>
                            <td class="p-3 align-middle border-light">
                            <p class="mb-0 small">R$ {{ number_format($item->unit_price,2,",",".") }}</p>
                            </td>
                            <td class="p-3 align-middle border-light">
                            <p class="mb-0 small" style="text-align: center;">{{ $item->quantity }}</p>
                            </td>
                            <td class="p-3 align-middle border-light">
                            <p class="mb-0 small">R$ {{ number_format(($item->unit_price * $item->quantity),2,",",".") }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <!-- ORDER TOTAL-->
        <div class="col-lg-4">
            <div class="card border-0 rounded-0 p-lg-4 bg-light">
            <div class="card-body">
                <h5 class="text-uppercase mb-4">Total do Pedido</h5>
                <ul class="list-unstyled mb-0">
                <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Subtotal</strong><span class="text-muted small">R$ {{  number_format($order->items_total,2,",",".") }}</span></li>
                <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Frete</strong><span class="text-muted small">R$ {{  number_format($order->shipment_total,2,",",".") }}</span></li>
                <li class="border-bottom my-2"></li>
                <li class="d-flex align-items-center justify-content-between mb-4"><strong class="text-uppercase small font-weight-bold">Total</strong><span>R$ {{  number_format(($order->items_total + $order->shipment_total),2,",",".") }}</span></li>
                </ul>
            </div>
            </div>
        </div>
        </div>
    </section>
</div>

@endsection