@extends('layouts.main')

@section('title', 'Ecommerce Pedro')

@section('content')
    <link rel="stylesheet" href="/js/glightbox/js/glightbox.min.css">
    <!-- Range slider-->
    <link rel="stylesheet" href="/js/nouislider/nouislider.min.css">
    <!-- Choices CSS-->
    <link rel="stylesheet" href="/js/choices.js/public/assets/styles/choices.min.css">
    <!-- Swiper slider-->
    <link rel="stylesheet" href="/js/swiper/swiper-bundle.min.css">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="/img/favicon.png">
    <script src="/js/loader.js"></script>
    {{-- SDK MercadoPago.js --}}
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <style>
      .custom-loader {
        border: 5px solid #b3b3b3;
        border-radius: 50%;
        border-top: 5px solid #0099ff;
        width: 30px;
        height: 30px;
        -webkit-animation: spin 0.6s linear infinite;
        animation: spin 0.6s linear infinite;
        position: sticky;
        bottom: 50%;
        margin: auto;
        display: none;
      }

      #cep-valor {
        padding: 5px 10px;
        text-align: center;
      }

      .frete-valor {
        font-size: 13px;
      }
      .frete-tipo {
        font-size: 13px;
      }

      /* Safari */
      @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    </style>
    <section class="py-5">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-6">
            <!-- PRODUCT SLIDER-->
            <div class="row m-sm-0">
              <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
                <div class="swiper product-slider-thumbs">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100" src="/img/uploads/{{ $product->image }}" alt="..."></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-10 order-1 order-sm-2">
                <div class="swiper product-slider">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide h-auto"><a class="glightbox product-view" href="/img/product-detail-1.jpg" data-gallery="gallery2" data-glightbox="Product item 1"><img class="img-fluid" src="/img/uploads/{{ $product->image }}" alt="..."></a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- PRODUCT DETAILS-->
          <div class="col-lg-6">
            <form id="product-form">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <input type="hidden" name="unit_price" value="{{ $product->price }}">
            <ul class="list-inline mb-2 text-sm">
              <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
              <li class="list-inline-item m-0 1"><i class="fas fa-star small text-warning"></i></li>
              <li class="list-inline-item m-0 2"><i class="fas fa-star small text-warning"></i></li>
              <li class="list-inline-item m-0 3"><i class="fas fa-star small text-warning"></i></li>
              <li class="list-inline-item m-0 4"><i class="fas fa-star small text-warning"></i></li>
            </ul>
            <h1>{{ $product->name }}</h1>
            <p class="text-muted lead">R$ {{ number_format($product->price,2,",",".") }}</p>
            <p class="text-sm mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Vestibulum ultricies aliquam convallis.</p>
            <div class="row align-items-stretch mb-4">
              <div class="col-sm-5 pr-sm-0">
                <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white"><span class="small mr-4 no-select">Quantidade:</span>
                  <div class="quantity">
                  <button type="button" class="btn-qnt p-0" data-action="minus"><i class="fas fa-caret-left"></i></button>
                  <input class="form-control border-0 shadow-0 p-0" type="number" id="quantity" name="quantity" value="1">
                  <button type="button"  class="btn-qnt p-0"  data-action="plus"><i class="fas fa-caret-right"></i></button>
                  </div>
                </div>
              </div>
              @auth
                <div class="col-sm-3 pl-sm-0">
                  <a id="btn-add-to-cart" class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" href="#">Adicionar</a>
                </div>
              @endauth
              @guest
                <div class="col-sm-3 pl-sm-0">
                  <a class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" href="/login">Adicionar</a>
                </div>
              @endguest
            </div>
            <div class="row align-items-stretch mb-4">
              <div class="col-sm-5 pr-sm-0">
                <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">
                  <div class="quantity">
                    <label for="quantity">CEP:</label>
                    <input class="form-control border-0 shadow-0 p-0" style="width: 100%;" placeholder="00.000-00" id="cep" name="cep" type="text" oninput="mascara(this,mcep);" maxlength="10" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="col-sm-3 pl-sm-0">
                <a id="btn-calcula-frete" class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" href="#">Calcular</a>
              </div>
            </div>
            <div class="row align-items-stretch mb-4">
              <div class="col-sm-8 pr-sm-0">
                <div class="custom-loader"></div>
                <div id="cep-valor" class="border" style="display: none;">
                  <span class="frete-tipo">SEDEX - chega em <strong>3 dias</strong></span> - <span class="frete-valor">Frete: <strong>R$ 25,49</strong></span><br>
                  <span class="frete-tipo">PAC - chega em <strong>6 dias</strong></span> - <span class="frete-valor">Frete: <strong>R$ 18,30</strong></span>
                </div>
              </div>
            </div>
            <ul class="list-unstyled small d-inline-block">
              <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">SKU:</strong><span class="ms-2 text-muted">{{ $product->id }}</span></li>
              <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">Categoria:</strong><a class="reset-anchor ms-2" href="#!">{{ $product->category }}</a></li>
            </ul>
            </form>
          </div>
        </div>
        <!-- DETAILS TABS-->
        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
          <li class="nav-item"><a class="nav-link text-uppercase active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Descrição</a></li>
          <li class="nav-item"><a class="nav-link text-uppercase" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Avaliações</a></li>
        </ul>
        <div class="tab-content mb-5" id="myTabContent">
          <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
            <div class="p-4 p-lg-5 bg-white">
              <h6 class="text-uppercase">Descrição do produto </h6>
              <p class="text-muted text-sm mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
          </div>
          <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
            <div class="p-4 p-lg-5 bg-white">
              <div class="row">
                <div class="col-lg-8">
                  <div class="d-flex mb-3">
                    <div class="flex-shrink-0"><img class="rounded-circle" src="/img/customer-1.png" alt="" width="50"/></div>
                    <div class="ms-3 flex-shrink-1">
                      <h6 class="mb-0 text-uppercase">Jason Doe</h6>
                      <p class="small text-muted mb-0 text-uppercase">20 May 2020</p>
                      <ul class="list-inline mb-1 text-xs">
                        <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                      </ul>
                      <p class="text-sm mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="flex-shrink-0"><img class="rounded-circle" src="/img/customer-2.png" alt="" width="50"/></div>
                    <div class="ms-3 flex-shrink-1">
                      <h6 class="mb-0 text-uppercase">Jane Doe</h6>
                      <p class="small text-muted mb-0 text-uppercase">20 May 2020</p>
                      <ul class="list-inline mb-1 text-xs">
                        <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star-half-alt text-warning"></i></li>
                      </ul>
                      <p class="text-sm mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="wallet_container"></div>
    </section>
      @vite(['resources/js/app.js'])
      <script>
        
        const mp = new MercadoPago('TEST-71ce55da-4762-4e63-8c73-326a0c9e580f', {
            locale: 'pt-BR'
        });

        const delay = ms => new Promise(res => setTimeout(res, ms));

        $('.btn-qnt').on('click', function() {
          let current_qnt = Number($('#quantity').val());
          if($(this).attr('data-action') == 'minus') {
            if(current_qnt > 1) {
              current_qnt -= 1;
            }
          } else {
            if(current_qnt < 10) {
              current_qnt += 1;
            }
          }
          $('#quantity').val(current_qnt);
        });

        $('#btn-add-to-cart').on('click', function() {
          let data = $('#product-form').serialize();
          $.ajax({
              type: "POST",
              url: "{{ route('add.cart') }}",
              data: data,
              dataType: 'json',
              success: async function(result) {
                  console.log(result);
                  if(result['status'] == 'success') {
                    swal({
                        title: 'Sucesso',
                        icon: result['status'],
                        text: result['message'],
                        buttons: false,
                        timer: 1500
                    });
                    await delay(1300);
                    window.location.href = '/';
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

        $('#btn-calcula-frete').on('click', async function() {

          // ---------------------------------
          $('#cep-valor').css('display', 'none');
          $('.custom-loader').css('display', 'block');
          let cep_destino = $('#cep').val();
          let weight = "{{ $product->weight }}";
          weight = isNaN(weight) ? 0.5 : Number(weight);
          if(cep_destino.length < 10) {
            swal({
              title: 'Atenção',
              icon: 'warning',
              text: 'Informe um CEP válido.'
            });
            return;
          }
          cep_destino = cep_destino.replace('.', '').replace('-', '');

          await delay(2000);
          $('.custom-loader').css('display', 'none');
          $('#cep-valor').css('display', 'block');
          // axios.defaults.headers.get['Content-Type'] ='application/x-www-form-urlencoded';
          // axios.get(`https://www.cepcerto.com/ws/json-frete/38405248/${cep_destino}/${weight}`)
          // .then(response => {
          //   console.log(response.data);
          // })
          // .catch(error => {
          //   console.log(error);
          // });

          // const request = new XMLHttpRequest()
          // request.open('GET', `https://www.cepcerto.com/ws/xml-frete/38405248/${cep_destino}/${weight}`)
          // request.setRequestHeader('Accept', 'jsonp');
          // request.onload = function () {
          //   console.log(JSON.parse(this.responseText))
          // }
          // request.onerror = function () {
          //   console.log('erro ao executar a requisição')
          // }
          // request.send();

          // $.ajax({
          //     type: "GET",
          //     url: `https://www.cepcerto.com/ws/xml-frete/38405248/${cep_destino}/${weight}`,
          //     crossDomain: true,
          //     dataType: 'jsonp',
          //     success: function(result) {
          //       console.log('teste');
          //         console.log(`${result}`);
          //     }
          // });
        })
      </script>

@endsection