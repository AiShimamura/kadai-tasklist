@extends('layouts.app')

@section('content')

   <div class="prose ml-4">
        <h2>id: {{ $tasks->id }} のタスク編集ページ</h2>
    </div>

    <div class="flex justify-center">
        <form method="POST" action="{{ route('tasks.update', $tasks->id) }}" class="w-1/2">
            @csrf
            @method('PUT')

                <div class="form-control my-4">
                    <label for="content" class="label">
                        <span class="label-text">タスク:</span>
                    </label>
                    <input type="text" name="content" value="{{ $tasks->content }}" class="input input-bordered w-full" required>
                </div>
                
                <div class="form-group">
                    <label for="status">ステータス:</label>
                    <input type="text" name="status" value="{{ $tasks->status }}" class="input input-bordered w-full" required>
                </div>

            <button type="submit" class="btn btn-primary btn-outline">更新</button>
        </form>
    </div>

@endsection