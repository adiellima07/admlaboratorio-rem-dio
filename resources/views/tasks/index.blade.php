<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>To-Do List Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">💊 Lembrete de Remédios</h1>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                Nova Tarefa
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Título/Descrição</label>
                        
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" 
                               placeholder="Ex: Tomar o remédio X às 10h" 
                               value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success me-10">Salvar Tarefa</button>
                    
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
        </div>

        <h2>Tarefas Pendentes 
            <span class="badge bg-secondary">{{ $tasks->where('is_completed', false)->count() }}</span>
        </h2>
        
        <ul class="list-group">
            @forelse ($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center 
                    {{ $task->is_completed ? 'list-group-item-success' : '' }}">
                    
                    <span class="flex-grow-1 {{ $task->is_completed ? 'text-decoration-line-through text-muted' : '' }}">
                        {{ $task->title }}
                    </span>

                    <div class="d-flex align-items-center">

    {{-- Editar --}}
    <a href="{{ route('tasks.edit', $task->id) }}"
       class="btn btn-sm btn-outline-info me-2">
        Editar
    </a>

    {{-- Concluir --}}
    @if(!$task->is_completed)
        <form method="POST"
              action="{{ route('tasks.complete', $task->id) }}"
              class="me-2">
            @csrf
            @method('PUT')
            <button type="submit"
                class="btn btn-sm btn-outline-success"
                onclick="return confirm('Marcar como concluída a tarefa: {{ $task->title }}?')">
                Concluir
            </button>
        </form>
    @endif

    {{-- Excluir --}}
    <form method="POST"
          action="{{ route('tasks.destroy', $task->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="btn btn-sm btn-outline-danger"
            onclick="return confirm('Excluir a tarefa: {{ $task->title }}?')">
            Excluir
        </button>
    </form>

</div>

                </li>
            @empty
                <li class="list-group-item">Nenhuma tarefa cadastrada.</li>
            @endforelse
        </ul>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>