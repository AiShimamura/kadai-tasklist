<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ログインしているユーザーのタスク一覧を表示
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $tasks = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'content' => 'required',
        'status' => 'required|max:10',
        ]);
    
                // タスクを作成
        $tasks = new Task;
        $tasks->content = $request->content;
        $tasks->status = $request->status;
        $tasks->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 他人のタスクにアクセスを制限
        if ($task->user_id !== auth()->id()) {
            return redirect()->route('tasks.index');
            }
        return view('tasks.show', compact('task'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 他人のタスクにアクセスを制限
        if ($task->user_id !== auth()->id()) {
            return redirect()->route('tasks.index');
        }
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 他人のタスクにアクセスを制限
        if ($task->user_id !== auth()->id()) {
        return redirect()->route('tasks.index');
        }
        
        // タスクを更新
        $tasks->content = $request->content;
        $tasks->status = $request->status;
        $tasks->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 他人のタスクにアクセスを制限
        if ($task->user_id !== auth()->id()) {
        return redirect()->route('tasks.index');
        }
        
        $tasks->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
