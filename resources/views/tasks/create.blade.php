<!DOCTYPE html>
<html>
<head>
    <title>Criar Tarefa</title>
</head>
<body>
    <h1>Nova Tarefa</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <label>Título:</label><br>
        <input type="text" name="title"><br><br>

        <label>Descrição:</label><br>
        <textarea name="description"></textarea><br><br>

        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('tasks.index') }}">Voltar</a>
</body>
</html>
