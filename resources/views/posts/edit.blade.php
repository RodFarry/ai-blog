@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <div class="form-group">
            <label for="excerpt">Excerpt</label>
            <input type="text" name="excerpt" class="form-control" value="{{ $post->excerpt }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="10">{{ $post->content }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" name="image" class="form-control" value="{{ $post->image }}">
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" class="form-control" value="{{ $post->category }}" required>
        </div>

        <div class="form-group">
            <label for="tags">Tags (comma-separated)</label>
            <input type="text" name="tags" class="form-control" value="{{ implode(', ', $post->tags) }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Post</button>
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
