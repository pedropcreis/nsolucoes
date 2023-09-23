@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Cart;

    $total_cart_orders = 0;
    $cart_url = '/login';
    if(Auth::check()) {
        $cart_url = '/cart';
        $total_cart_orders = Cart::where('user_id', Auth::user()->id)->count();
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/style.default.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>
            <script src="/js/mascara.js"></script>
            <script src="/js/sweetalert.min.js"></script>

        <title>@yield('title')</title>

    </head>
    <body>
        <div class="page-holder">
            <header class="header bg-white">
                <div class="container px-lg-3">
                <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="/"><span class="fw-bold text-uppercase text-dark">Loja</span></a>
                    <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                        <!-- Link--><a class="nav-link active" href="/">Início</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">               
                        <li class="nav-item"><a class="nav-link" href="{{ $cart_url }}"> <i class="fas fa-dolly-flatbed me-1 text-gray"></i>Carrinho<small class="text-gray fw-normal">({{ $total_cart_orders }})</small></a></li>
                        @auth
                            <form action="/logout" method="POST">
                                @csrf
                                <li class="nav-item"><a class="nav-link" href="/logout" onclick="event.preventDefault();this.closest('form').submit();"> <i class="fas fa-user me-1 text-gray fw-normal"></i>Sair</a></li>
                            </form>
                        @endauth
                        @guest
                            <li class="nav-item"><a class="nav-link" href="/login"> <i class="fas fa-user me-1 text-gray fw-normal"></i>Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="/register">Cadastrar</a></li>
                        @endguest
                    </ul>
                    </div>
                </nav>
                </div>
            </header>
            @yield('content')
            <footer class="bg-dark text-white">
                <div class="container py-4">
                    <div class="row py-5">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="text-uppercase mb-3">Customer services</h6>
                            <ul class="list-unstyled mb-0">
                                <li><a class="footer-link" href="#!">Help &amp; Contact Us</a></li>
                                <li><a class="footer-link" href="#!">Returns &amp; Refunds</a></li>
                                <li><a class="footer-link" href="#!">Online Stores</a></li>
                                <li><a class="footer-link" href="#!">Terms &amp; Conditions</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="text-uppercase mb-3">Company</h6>
                            <ul class="list-unstyled mb-0">
                                <li><a class="footer-link" href="#!">What We Do</a></li>
                                <li><a class="footer-link" href="#!">Available Services</a></li>
                                <li><a class="footer-link" href="#!">Latest Posts</a></li>
                                <li><a class="footer-link" href="#!">FAQs</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-uppercase mb-3">Social media</h6>
                            <ul class="list-unstyled mb-0">
                                <li><a class="footer-link" href="#!">Twitter</a></li>
                                <li><a class="footer-link" href="#!">Instagram</a></li>
                                <li><a class="footer-link" href="#!">Tumblr</a></li>
                                <li><a class="footer-link" href="#!">Pinterest</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-top pt-4" style="border-color: #1d1d1d !important">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-start">
                                <p class="small text-muted mb-0">&copy; 2021 All rights reserved.</p>
                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <p class="small text-muted mb-0">Template designed by <a class="text-white reset-anchor" href="https://bootstrapious.com/p/boutique-bootstrap-e-commerce-template">Bootstrapious</a></p>
                                <!-- If you want to remove the backlink, please purchase the Attribution-Free License. See details in readme.txt or license.txt. Thanks!-->
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
      <!-- JavaScript files-->
      <script src="/js/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="/js/glightbox/js/glightbox.min.js"></script>
      <script src="/js/nouislider/nouislider.min.js"></script>
      <script src="/js/swiper/swiper-bundle.min.js"></script>
      <script src="/js/choices.js/public/assets/scripts/choices.min.js"></script>
      <script src="/js/front.js"></script>
      <!-- Nouislider Config-->
      <script>
        var range = document.getElementById('range');
        noUiSlider.create(range, {
            range: {
                'min': 0,
                'max': 2000
            },
            step: 5,
            start: [100, 1000],
            margin: 300,
            connect: true,
            direction: 'ltr',
            orientation: 'horizontal',
            behaviour: 'tap-drag',
            tooltips: true,
            format: {
              to: function ( value ) {
                return '$' + value;
              },
              from: function ( value ) {
                return value.replace('', '');
              }
            }
        });
        
      </script>
      <script>
        // ------------------------------------------------------- //
        //   Inject SVG Sprite - 
        //   see more here 
        //   https://css-tricks.com/ajaxing-svg-sprite/
        // ------------------------------------------------------ //
        function injectSvgSprite(path) {
        
            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }
        // this is set to BootstrapTemple website as you cannot 
        // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
        // while using file:// protocol
        // pls don't forget to change to your domain :)
        injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 
        
      </script>
        </div>
    </body>
</html>
