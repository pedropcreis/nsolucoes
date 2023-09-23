<x-app-layout>
    <style>
        select[name='sales_table_length'] {
            width: 75px;
        }
        #sales_table_wrapper {
            width: 95%;
            margin: auto;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendas') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <table id="sales_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data/hora</th>
                    <th>Usuário</th>
                    <th>Valor</th>
                    <th>Forma de pagamento</th>
                </tr>
            </thead>
        </table>
    </div>
    <script>
        $('#sales_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('sales.ajax') }}",
            columns: [
                {'data': 'id', name: 'sales.id'},
                {'data': 'date', name: 'sales.created_at'},
                {'data': 'user_name', name: 'users.name'},
                {'data': 'total', name: 'sales.items_total'},
                {'data': 'payment_type_id', name: 'transactions.payment_type_id'}
            ]
        });
    </script>
</x-app-layout>
