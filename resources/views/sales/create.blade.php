<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar produto') }}
        </h2>
    </x-slot>
    <style>
        .form-control {
            border-radius: 5px !important;

            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: var(--bs-body-bg);
            background-clip: padding-box;
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        .form-control:focus {
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
        }
    </style>
    <div class="container">
        <form id="form-cadastrar-produto" action="{{ route('store.product') }}" method="POST">
            @csrf
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-6">
                    <label for="name">Nome: * </label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" maxlength="255">
                </div>
                <div class="col-md-3">
                    <label for="category_id">Categoria: * </label>
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="price">Preço (R$): * </label>
                    <input type="number" name="price" id="price" class="form-control">
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-2">
                    <label for="length">Comprimento (cm): * </label>
                    <input type="number" name="length" id="length" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="width">Largura (cm): * </label>
                    <input type="number" name="width" id="width" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="height">Altura (cm): * </label>
                    <input type="number" name="height" id="height" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="weight">Peso (kg): * </label>
                    <input type="number" name="weight" id="weight" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="image">Imagem (máx. 5mb): </label>
                    <input type="file" name="image" id="image" accept="image/*" class="form-control">
                </div>
            </div>
            <div class="row" style="margin-top: 25px;">
                <div class="col-md-12" style="text-align: center;">
                    <button id="btn-cadastrar" onclick="event.preventDefault();" class="btn btn-success" style="width: 35%; height: 45px;">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $('#btn-cadastrar').on('click', function() {
            if($("input[name='image']").prop('files').length > 0) {
                let filesize = Number((($("input[name='image']").prop('files')[0].size/(1024*1024))).toFixed(4)); // pega o size da imagem em Bytes e converte para MB
                console.log(filesize);
                if(filesize > 5) { // se a size da imagem for maior que 5mb, dá um aviso ao usuário
                    swal({
                        title: 'Atenção',
                        icon: 'warning',
                        text: 'O tamanho máximo pertimido para a imagem é de 5MB.'
                    });
                    return;
                }
            }

            if(
                $("input[name='name']").val().trim().length === 0 ||
                $("input[name='price']").val().trim().length === 0 ||
                $("input[name='length']").val().trim().length === 0 ||
                $("input[name='width']").val().trim().length === 0 ||
                $("input[name='height']").val().trim().length === 0 ||
                $("input[name='weight']").val().trim().length === 0

            ) {
                swal({
                    title: 'Atenção',
                    icon: 'warning',
                    text: 'Nenhum campo pode ficar vazio.'
                });
                return;
            }
            let data = new FormData(document.getElementById('form-cadastrar-produto'));
            // let data = $('#form-cadastrar-produto').serialize();

            $.ajax({
                type: "POST",
                data: data,
                url: $('#form-cadastrar-produto').attr('action'),
                processData: false,
                contentType: false,
                success: function(result) {
                    console.log(result);
                    if(result['status'] == 'success') {
                        swal({
                            title: 'Sucesso',
                            icon: result['status'],
                            text: result['message'],
                            buttons: false,
                            timer: 1500
                        });
                        window.location.href = '/products';
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
</x-app-layout>
