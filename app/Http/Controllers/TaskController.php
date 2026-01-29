<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('is_completed')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => false
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // --- CORREÇÃO APLICADA AQUI ---
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            
            // CORRIGIDO: Agora pegamos o valor (0 ou 1) que vem do input hidden ou do checkbox
            // Não usamos mais o has(), pois o campo sempre existe.
            'is_completed' => $request->is_completed 
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tarefa atualizada com sucesso.');
    }
    // ------------------------------

    /**
     * Marcar tarefa como concluída (Via botão direto na lista, se houver)
     */
    public function complete(Task $task)
    {
        if ($task->is_completed) {
            return redirect()
                ->route('tasks.index')
                ->with('success', 'Esta tarefa já está concluída.');
        }

        $task->update([
            'is_completed' => true
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tarefa concluída com sucesso.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tarefa excluída com sucesso.');
    }
}