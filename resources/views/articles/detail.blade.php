@extends("layouts.app")

@section("content")
<div class="container">
{{ $name }}

    @if($errors->any())
    <div class="alert alert-warning">
        <ol>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info text-center">
        {{ session('info') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-warning text-center">
        {{ session('error') }}
    </div>
    @endif
    <h3 class="card-title">{{ $article->title }}</h3>
    <p class="text-muted mb-2">
        {{ $article->created_at->diffForHumans() }}
        Category: <b>{{ $article->category->name }}</b>
    </p>
    <p class="text-muted mb-2">
        By: <b>{{ $article->user->name }}</b>
    </p>
    <p class="">{{ $article->body }}</p>
    @auth
    @if(auth()->user()->id == $article->user->id)
    <a href="{{ route('articles.edit', ['id' => $article->id]) }}" class="btn btn-info">Edit</a>
    <form method="POST" action="{{ route('articles.delete') }}" class="d-inline-block">
        @csrf
        <input type="hidden" name="id" value="{{ $article->id }}">
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    @endif
    @endauth
    <ul class="list-group my-3">
        <li class="list-group-item active">
            Comments ({{ count($article->comments) }})
        </li>
        @foreach($article->comments as $comment)
        <li class="list-group-item d-flex">
            <p class="flex-fill my-auto">
                {{ $comment->content }}
                <br>
                <small class="mt-2">By <b>{{ $comment->user->name }}</b>, {{ $comment->created_at->diffForHumans() }}</small>
            </p>
            @auth
            @if(auth()->user()->id == $comment->user->id)
            <form action="{{ route('comments.delete') }}" method="POST" class="d-inline-block float-end">
                @csrf
                <input type="hidden" name="id" value="{{ $comment->id }}">
                <button type="submit" class="btn btn-danger">&times</button>
            </form>
            @endif
            @endauth
        </li>
        @endforeach
    </ul>
    @auth
    <form action="{{ route('comments.add') }}" method="POST">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <textarea name="content" class="form-control mb-3" placeholder="New Comment"></textarea>
        <input type="submit" value="Add Comment" class="btn btn-primary">
    </form>
    @endauth
</div>
@endsection