@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Manage Topics</h1>
        
        <a href="{{ route('topics.create') }}" class="btn btn-primary">Add New Topic</a>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topics as $topic)
                    <tr>
                        <td>{{ $topic->title }}</td>
                        <td>
                            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('topics.destroy', $topic->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
