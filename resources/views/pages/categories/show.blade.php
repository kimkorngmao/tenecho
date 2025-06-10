@extends('layouts.app')

@section('title', $category->name . ' - News Articles')
@section('meta_description', $category->description ?? 'Explore the latest news articles in ' . $category->name . ' category')

@section('content')
<main class="mx-auto">
    {{-- Newspaper-style header --}}
    <header class="mb-6">
        {{-- Breadcrumb navigation --}}
        <nav aria-label="Breadcrumb" class="flex items-center text-xs text-gray-600 mb-3 uppercase tracking-widest">
            <ol class="flex items-center">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-black">Home</a>
                </li>
                @if ($category->parent)
                    <li aria-hidden="true" class="mx-2">•</li>
                    <li>
                        <a href="{{ route('categories.show', $category->parent->slug) }}" class="hover:text-black">
                            {{ $category->parent->name }}
                        </a>
                    </li>
                @endif
                <li aria-hidden="true" class="mx-2">•</li>
                <li aria-current="page" class="text-black font-semibold">{{ $category->name }}</li>
            </ol>
        </nav>
    </header>

    {{-- Category heading --}}
    <h1 class="sr-only">{{ $category->name }} Articles</h1>

    {{-- Articles list --}}
    <section aria-labelledby="category-articles-heading">
        <h2 id="category-articles-heading" class="sr-only">Articles in {{ $category->name }}</h2>
        
        <div class="space-y-8 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-5">
            @foreach ($category->articles->where('status', 'published')->where('type', 'news') as $article)
                <article class="group" itemscope itemtype="http://schema.org/NewsArticle">
                    <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" class="block" itemprop="url">
                        <figure itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                            <img 
                                src="{{ $article->featured_image_url ?? asset('images/thumb-placeholder.jpg') }}" 
                                alt="{{ $article->title }}"
                                class="w-full aspect-video object-cover"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('images/thumb-placeholder.jpg') }}';"
                                itemprop="contentUrl"
                            />
                        </figure>
                        <h3 class="mt-2 line-clamp-2 group-hover:underline" itemprop="headline">{{ $article->title }}</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <time datetime="{{ $article->published_at }}" itemprop="datePublished">
                                {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                            </time>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </section>
</main>
@endsection