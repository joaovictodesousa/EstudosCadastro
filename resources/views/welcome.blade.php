@include('cabecalho')

<div>
    <div style="display: flex; justify-content: center; align-items: center;">
        @if (session('success'))
            <div class="alert_sucesso">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.querySelector('.alert_sucesso').style.display = 'none';
                }, {{ session('display_time', 5000) }});
            </script>
        @endif
        {{--  --}}
        @if (session('danger'))
            <div class="alert_danger">
                {{ session('danger') }}
            </div>
            <script>
                setTimeout(function() {
                    document.querySelector('.alert_danger').style.display = 'none';
                }, {{ session('display_time', 5000) }});
            </script>
        @endif
    </div>
    {{-- -------------------------------------- --}}



    @if (request('search'))
        <!-- Campo de cadastro será ocultado se uma pesquisa foi realizada -->
    @else
        <section class="container_campos">
            <div class="container_form">
                <form action="{{ route('welcome.home') }}" method="GET">
                    @csrf
                    <div class="input-container">
                        <label>PESQUISAR</label>
                        <div class="input_btn">
                            <input type="text" id="search" name="search" placeholder="Pesquisar por nome..."
                                value="{{ request('search') }}">
                            <button type="submit" class="butao_pesquisar">PESQUISAR</button>
                            {{-- @if (request('search'))
                                <a href="{{ route('welcome.home') }}" class="butao_cancelar">Cancelar</a>
                            @endif --}}
                        </div>
                    </div>
                </form>
            </div>

            {{--  --}}
            <div class="container_form">
                <form action="{{ route('welcome.store') }}" method="POST">
                    @csrf
                    <div class="input-container">
                        <label>CADASTRAR</label>
                        <div class="input_btn">
                            <input type="text" id="name" name="name" placeholder="Digite seu nome..."
                                required>
                            <button type="submit" class="butao_cadastrar">CADASTRAR</button>
                        </div>
                    </div>
                </form>
            </div>
    @endif
    </section>
    <br><br><br>
    {{-- INICIO DA FUNÇÃO QUE USA A TABELA PARA FILTRAR TAMBÉM --}}

    @if (count($Allcadastros) > 0)
        <table class="table" id="tabela">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Allcadastros as $cadastro)
                    <tr>
                        <td>{{ $cadastro->name }}</td>
                        <td>
                            <div class="th_acoes">
                                <form action="{{ route('welcome.destroy', ['cadastro' => $cadastro->id]) }}"
                                    method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="butao" title="Excluir">Excluir</button>
                                </form>
                                <a type="button" class="butao_edit"
                                    href="{{ route('welcome.edit', ['cadastro' => $cadastro->id]) }}"
                                    title="Editar">Editar</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table><br>
        <div class="container_paginate">
            {{ $Allcadastros->appends([
                    'search' => request()->get('search', ''),
                ])->links() }}
        </div>
    @else
        <p class="alert_naoencontrado">Nenhum resultado encontrado. 😢</p>
    @endif
    {{-- FIM DA FUNÇÃO QUE USA A TABELA PARA FILTRAR TAMBÉM --}}

    <br><br>
    <div class="container_acoes">
        <a href="{{ route('gerar-pdf', ['search' => $search]) }}" class="btn btn-primary" id="btn">Gerar PDF</a>
        @if (request('search'))
            <a href="{{ route('welcome.home') }}" class="btn btn-danger" id="btn">Cancelar</a>
        @endif
    </div>
    <br><br><br>
</div>

<div class="container_trol">
    <a class="link_trol" href="{{ route('welcome.mudar') }}">Derrubar sistema</a>
</div>
