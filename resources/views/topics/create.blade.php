@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Topic</h1>

        <form action="{{ route('topics.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
@endsection
