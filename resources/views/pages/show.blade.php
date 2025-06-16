@extends($article->type == 'standalone' ? 'layouts.blank' : 'layouts.app')

@section('title', $article->title)
@section('meta_description', $article->meta_description ?? ($article->excerpt ?? Str::limit(strip_tags($article->content), 150)))

@section('content')
    @if ($article->type == 'standalone')
        {!! $article->content !!}
    @else
        <div class="prose">
            {!! $article->content !!}
        </div>
    @endif
@endsection
