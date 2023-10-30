<!DOCTYPE html>
<html>
<head>
    <title>PDF Gerado</title>
</head>
<body>
    <h1>Conteúdo do PDF Gerado</h1>
    <ul>
        @foreach ($Allcadastros as $cadastro)
            <li>{{ $cadastro->name }}</li>
        @endforeach
    </ul>
</body>
</html>
