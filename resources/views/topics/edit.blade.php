@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Topic</h1>

        <form action="{{ route('topics.update', $topic->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $topic->title }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
