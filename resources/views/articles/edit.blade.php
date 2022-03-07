@extends("layouts.app")

@section("content")
<div class="container">
    @if($errors->any())
    <div class="alert alert-warning">
        <ol>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
    @endif
    <form action="{{ route('articles.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $article->id }}">
        <div class="mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ $article->title }}" id="title" class="form-control">
        </div>
        <div class="mb-3">
            <label for="body">nody</label>
            <textarea name="body" id="body" class="form-control">
            {{ $article->body }}
            </textarea>
        </div>
        <div class="mb-3">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}" {{ $article->category->id === $category->id ? 'selected' : '' }}>{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Add Article</button>
    </form>
</div>
@endsection