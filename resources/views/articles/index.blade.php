@extends("layouts.app")

@section("content")
<div class="container">

    @if(session('info'))
    <div class="alert alert-info text-center">
        {{ session("info") }}
    </div>
    @endif
{{ $name }}
    @foreach ($articles as $article)
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">{{ $article->title }}</div>
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