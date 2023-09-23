<x-app-layout>
    <style>
        select[name='products_table_length'] {
            width: 75px;
        }
        #products_table_wrapper {
            width: 95%;
            margin: auto;
        }
        #add-user {
            height: 45px;
            border-radius: 10px;
            width: 95%;
            line-height: 30px;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produtos') }}
        </h2>
    </x-slot>
    <div class="row" style="text-align: end; margin-top: 25px;">
        <div class="col-md-12" style="text-align: center;">
            <a id="add-user" class="btn btn-success" href="{{ route('create.product') }}"><i class="fas fa-plus"></i> Novo produto</a>
        </div>
    </div>
    <div class="py-12">
        <table id="products_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Comprimento</th>
                    <th>Largura</th>
                    <th>Altura</th>
                    <th>Categoria</th>
                </tr>
            </thead>
        </table>
    </div>
    <script>
        $('#products_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.ajax') }}",
            columns: [
                {'data': 'id', name: 'products.id'},
                {'data': 'name', name: 'products.name'},
                {'data': 'price', name: 'products.price'},
                {'data': 'length', name: 'products.length'},
                {'data': 'width', name: 'products.width'},
                {'data': 'height', name: 'products.height'},
                {'data': 'category', name: 'categories.name'},
            ]
        });
    </script>
</x-app-layout>
