@include('cabecalho')

<div class="container_form">
    <form action="{{ route('welcome.update', ['cadastro' => $cadastro->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" id="name" name="name" value="{{ $cadastro->name }}" required>
        <button type="submit" class="butao_cadastrar">ATUALIZAR</button>
    </form>
</div>
