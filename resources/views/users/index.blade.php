<x-app-layout>
    <style>
        select[name='users_table_length'] {
            width: 75px;
        }
        #users_table_wrapper {
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
            {{ __('Usuários') }}
        </h2>
    </x-slot>
    <div class="row" style="text-align: end; margin-top: 25px;">
        <div class="col-md-12" style="text-align: center;">
            <a id="add-user" class="btn btn-success" href="{{ route('create.user') }}"><i class="fas fa-plus"></i> Novo usuário</a>
        </div>
    </div>
    <div class="py-12">
        <table id="users_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                </tr>
            </thead>
        </table>
    </div>
    <script>
        $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.ajax') }}",
            columns: [
                {'data': 'id'},
                {'data': 'name'},
                {'data': 'email'}
            ]
        });
    </script>
</x-app-layout>
