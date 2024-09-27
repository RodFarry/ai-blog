@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create New Post</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="excerpt">Excerpt</label>
            <input type="text" name="excerpt" class="form-control" value="{{ old('excerpt') }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="10">{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" name="image" class="form-control" value="{{ old('image') }}">
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}" required>
        </div>

        <div class="form-group">
            <label for="tags">Tags (comma-separated)</label>
            <input type="text" name="tags" class="form-control" value="{{ old('tags') }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Post</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content', {
        removePlugins: 'a11ychecker', // Remove the accessibility checker
        on: {
            instanceReady: function(ev) {
                // Suppress the version warning message
                this.on('notificationShow', function(event) {
                    event.cancel();
                });
            }
        }
    });
</script>
@endsection
