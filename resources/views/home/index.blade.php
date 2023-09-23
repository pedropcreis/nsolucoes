@extends('layouts.main')

@section('title', 'Ecommerce Pedro')

@section('content')

      <style>
        .btn-category {
          cursor: pointer;
        }
        .btn-category:hover {
          background-color: #e0e0e0 !important;
          color: #000 !important;
        }
      </style>
      <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
              <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Comprar</h1>
              </div>
              <div class="col-lg-6 text-lg-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                    <li class="breadcrumb-item"><a class="text-dark" href="/">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Comprar</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </section>

        <section class="py-5">
          <div class="container p-0">
            <div class="row">
              <!-- SHOP SIDEBAR-->
              <div class="col-lg-3 order-2 order-lg-1">
                <h5 class="text-uppercase mb-4">Categorias</h5>
                @foreach($categories as $category)
                  <form action="/" method="GET">
                    <input type="hidden" name="selected_category" value="{{ $category->id }}">
                    <div class="btn-category py-2 px-4 {{ $selected_category == $category->id ? 'bg-dark text-white' : 'bg-light' }} mb-3" onclick="this.closest('form').submit()"><strong class="small text-uppercase fw-bold">{{ $category->name }}</strong></div>
                  </form>
                @endforeach
              </div>
              <!-- SHOP LISTING-->
              <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                <div class="row">
                  <!-- PRODUCT-->
                  @foreach($products as $product)
                  <div class="col-lg-4 col-sm-6">
                    <div class="product text-center">
                      <div class="mb-3 position-relative">
                        <div class="badge text-white bg-"></div><a class="d-block" href="/detail/{{ $product->id }}"><img class="img-fluid w-100" src="/img/uploads/{{ $product->image }}" alt="..."></a>
                        
                      </div>
                      <h6> <a class="reset-anchor" href="detail.html">{{ $product->name }}</a></h6>
                      <p class="small text-muted">R$ {{ number_format($product->price,2,",",".") }}</p>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

@endsection