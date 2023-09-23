<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar usuário') }}
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
        <form id="form-cadastrar-usuario" action="{{ route('store.user') }}" method="POST">
            @csrf
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-6">
                    <label for="name">Nome: * </label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" maxlength="255">
                </div>
                <div class="col-md-6">
                    <label for="email">E-mail: * </label>
                    <input type="email" name="email" id="email" class="form-control" autocomplete="off" maxlength="255">
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-6">
                    <label for="email">Senha: * </label>
                    <input type="password" name="password" id="password" class="form-control" maxlength="255">
                </div>
                <div class="col-md-6">
                    <label for="user_type">Tipo do usuário: * </label>
                    <select name="user_type" id="user_type" class="form-control">
                        <option value="F">Funcionário</option>
                        <option value="A">Administrador</option>
                    </select>
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
            if(
                $("input[name='name']").val().trim().length === 0 ||
                $("input[name='email']").val().trim().length === 0 ||
                $("input[name='password']").val().length === 0
            ) {
                swal({
                    title: 'Atenção',
                    icon: 'warning',
                    text: 'Nenhum campo pode ficar vazio.'
                });
                return;
            }

            let data = $('#form-cadastrar-usuario').serialize();

            $.ajax({
                type: "POST",
                data: data,
                url: $('#form-cadastrar-usuario').attr('action'),
                dataType: "json",
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
                        window.location.href = '/users';
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
