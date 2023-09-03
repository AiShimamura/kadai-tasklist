@extends('layouts.app')

@section('content')

    <div class="prose ml-4">
        <h2>タスク 一覧</h2>
    </div>

    @if (isset($tasks))
        <table class="table table-zebra w-full my-4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>タスク</th>
                    <th>ステータス</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $tasks)
                <tr>
                    <td><a class="link link-hover text-info" href="{{ route('tasks.show', $tasks->id) }}">{{ $tasks->id }}</a></td>
                    <td>{{ $tasks->content }}</td>
                    <td>{{ $tasks->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- メッセージ作成ページへのリンク --}}                                               
    <a class="btn btn-primary" href="{{ route('tasks.create') }}">タスクの投稿</a>


@endsection