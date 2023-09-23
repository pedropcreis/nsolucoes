@extends('layouts.main')

@section('title', 'Carrinho')

@section('content')

{{-- SDK MercadoPago.js --}}
<script src="https://sdk.mercadopago.com/js/v2"></script>

<div class="container">
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
            <h1 class="h2 text-uppercase mb-0">Carrinho</h1>
            </div>
            <div class="col-lg-6 text-lg-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                <li class="breadcrumb-item"><a class="text-dark" href="/">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Carrinho</li>
                </ol>
            </nav>
            </div>
        </div>
        </div>
    </section>
    <section class="py-5">
        <h2 class="h5 text-uppercase mb-4">Carrinho de compras</h2>
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
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase"></strong></th>
                </tr>
                </thead>
                <tbody class="border-0">
                    @php
                        $cart_total = 0;
                    @endphp
                    @foreach ($cart_items as $item)
                        @php
                            $cart_total += $item->unit_price * $item->quantity;
                        @endphp
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
                            <td class="p-3 align-middle border-light"><a class="reset-anchor" href="#!"><i class="fas fa-trash-alt small text-muted"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- CART NAV-->
            <div class="bg-light px-4 py-3">
            <div class="row align-items-center text-end" style="margin-bottom: 10px;">
                <div class="col-md-12">
                <div id="cep-valor" class="bg-light" style="font-size: 14px;">
                    <label>
                        <span class="frete-tipo"><input type="radio" name="tipo-frete" value="sedex"> SEDEX - chega em <strong>3 dias</strong></span> - <span class="frete-valor">Frete: <strong>R$ 25,49</strong></span>
                    </label>
                    <br>
                    <label>
                        <span class="frete-tipo"><input type="radio" name="tipo-frete" value="pac"> PAC - chega em <strong>6 dias</strong></span> - <span class="frete-valor">Frete: <strong>R$ 18,30</strong></span>
                    </label>
                </div>
                </div>
            </div>
            <div class="row align-items-center text-center">
                <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm" href="/"><i class="fas fa-long-arrow-alt-left me-2"> </i>Continuar comprando</a></div>
                <div class="col-md-6 text-md-end"><a id="btn-pagamento" class="btn btn-outline-dark btn-sm" href="#">Ir para pagamento<i class="fas fa-long-arrow-alt-right ms-2"></i></a></div>
            </div>
            </div>
        </div>
        <!-- ORDER TOTAL-->
        <div class="col-lg-4">
            <div class="card border-0 rounded-0 p-lg-4 bg-light">
            <div class="card-body">
                <h5 class="text-uppercase mb-4">Total do carrinho</h5>
                <ul class="list-unstyled mb-0">
                <li class="d-flex align-items-center justify-content-between"><strong class="text-uppercase small font-weight-bold">Subtotal</strong><span class="text-muted small">R$ {{  number_format($cart_total,2,",",".") }}</span></li>
                <li class="border-bottom my-2"></li>
                <li class="d-flex align-items-center justify-content-between mb-4"><strong class="text-uppercase small font-weight-bold">Total</strong><span>R$ {{  number_format($cart_total,2,",",".") }}</span></li>
                </ul>
            </div>
            </div>
        </div>
        </div>
    </section>
</div>

<script>
    const mp = new MercadoPago('TEST-71ce55da-4762-4e63-8c73-326a0c9e580f', {
        locale: 'pt-BR'
    });
    $('#btn-pagamento').on('click', function() {
        let tipo_frete = $("input[name='tipo-frete']:checked").val();
        if(!tipo_frete) {
            swal({
                title: 'Atenção',
                icon: 'warning',
                text: 'Informe o tipo de frete.'
            });
            return;
        }
        let shipment_total = 0;
        if(tipo_frete == 'sedex') {
            shipment_total = 25.49;
        } else {
            shipment_total = 18.30;
        }
        $.ajax({
              type: "POST",
              url: "{{ route('store.sale') }}",
              data: {shipment_total: shipment_total, _token: "{{ csrf_token() }}"},
              dataType: 'json',
              success: async function(result) {
                  console.log(result);
                  if(result['status'] == 'success') {
                    mp.checkout({
                        preference: {
                            id: result['preference_id']
                        },
                    }).open();
                  } else {
                    swal({
                        title: 'Erro',
                        icon: result['status'],
                        text: result['message']
                    });
                  }
              }
          });
    });
</script>

@endsection