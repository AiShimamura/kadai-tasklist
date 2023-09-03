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
                // タスク一覧を取得
        $tasks = Task::all();         // 追加

        // タスク一覧ビューでそれを表示
        return view('tasks.index', [     // 追加
            'tasks' => $tasks,        // 追加
        ]);    
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
                // idの値でタスクを検索して取得
        $tasks = Task::findOrFail($id);

        // タスク詳細ビューでそれを表示
        return view('tasks.show', [
            'tasks' => $tasks,
                    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
                // idの値でタスクを検索して取得
        $tasks = Task::findOrFail($id);

        // タスク編集ビューでそれを表示
        return view('tasks.edit', [
            'tasks' => $tasks,
                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'content' => 'required',
        'status' => 'required|max:10',
        ]);
        
                // idの値でタスクを検索して取得
        $tasks = Task::findOrFail($id);
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
        // idの値でタスクを検索して取得
        $tasks = Task::findOrFail($id);
        // タスクを削除
        $tasks->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
