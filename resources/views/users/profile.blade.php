@extends("layouts.app")

@section("content")
<div class="container">

    @if(session('info'))
    <div class="alert alert-info text-center">
        {{ session("info") }}
    </div>
    @endif

    @foreach ($articles as $article)
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title d-flex">
                <h3 class="h5 my-auto flex-fill">{{ $article->title }}</h3>
                @auth
                @if(auth()->user()->id == $article->user->id)
                <div>
                    <a href="{{ route('articles.edit', ['id' => $article->id]) }}" class="btn btn-info">Edit</a>
                    <form method="POST" action="{{ route('articles.delete') }}" class="d-inline-block">
                        @csrf
                        <input type="hidden" name="id" value="{{ $article->id }}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                @endif
                @endauth
            </div>
            <p class="text-muted mb-2">
                {{ $article->created_at->diffForHumans() }}
                Category: <b>{{ $article->category->name }}</b>
            </p>
            <p class="text-muted mb-2">
                By: <b>{{ $article->user->name }}</b>
            </p>
            <div class="card-text">{{ $article->body }}</div>
            <a href="{{ route('articles.detail', ['id' => $article->id]) }}" class="card-link">View Detail &raquo;</a>
        </div>
    </div>
    @endforeach
    {{ $articles->links() }}
</div>
@endsection