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
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザのタスク一覧を取得
            $tasks = Task::where('user_id', $user->id)->get();
            
        // indexビューでそれらを表示
        return view('tasks.index',[
                'tasks' => $tasks,
        ]);
    }else{
        // ユーザーがログインしていない場合
        return redirect()->route('login');
        }
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
    
        // 認証済みユーザのタスクとして作成
        $tasks = new Task;
        $tasks->content = $request->input('content');
        $tasks->status = $request->input('status');
        
        // ユーザーに関連付けて保存
        $request->user()->tasks()->save($tasks);

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // idの値でタスクを検索して取得
            $tasks = Task::where('user_id', $user->id)->findOrFail($id);

        // タスク詳細ビューでそれを表示
        return view('tasks.show', [
            'tasks' => $tasks,
                    ]);
    }else{
        // ユーザーがログインしていない場合
        return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // idの値でタスクを検索して取得
            $tasks = Task::where('user_id', $user->id)->findOrFail($id);

            // タスク編集ビューでそれを表示
            return view('tasks.edit', [
                'tasks' => $tasks,
                        ]);

    }else{
        // ユーザーがログインしていない場合
        return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            // タスクを取得
        $tasks = Task::findOrFail($id);
        
        // 他人のタスクにアクセスを制限
        if ($tasks->user_id !== auth()->id()) {
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
        // タスクを取得
        $tasks = Task::findOrFail($id);
        
        // 他人のタスクにアクセスを制限
        if ($tasks->user_id !== auth()->id()) {
        return redirect()->route('tasks.index');
        }
        
        $tasks->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
