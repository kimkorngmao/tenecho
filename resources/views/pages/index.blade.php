@extends('layouts.app')

@section('content')
<main>
    <!-- Featured Articles Section -->
    <section>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach ($featuredArticles as $article)
                @if ($loop->first)
                    <article class="group block relative w-full h-full md:aspect-video overflow-hidden">
                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" class="block h-full">
                            <figure>
                                <img src="{{ $article->featured_image_url ?? '/images/placeholder.jpg' }}"
                                    alt="{{ $article->title }}"
                                    class="object-cover w-full h-full transition-opacity duration-500 ease-in-out" loading="lazy" />
                            </figure>
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#002244cc] to-transparent"></div>

                            <!-- Text Overlay -->
                            <div class="absolute bottom-0 left-0 p-6 text-white">
                                <!-- Category Label box with drop shadow -->
                                <div class="inline-block bg-white px-3 mb-2 shadow-[4px_4px_0px_rgba(255,188,59,1)]">
                                    <span class="text-black font-semibold text-sm">{{ $article->category?->name }}</span>
                                </div>

                                <!-- Title -->
                                <div class="mb-8">
                                    <h1 class="text-xl md:text-2xl font-bold text-white text-opacity-95 line-clamp-2">
                                        {{ $article->title }}
                                    </h1>
                                    <div class="w-0 group-hover:w-18 duration-200 h-0.5 bg-white"></div>
                                </div>
                            </div>
                        </a>
                    </article>
                @else
                    @if ($loop->index == 1)
                        <div class="grid grid-rows-3 gap-5">
                    @endif

                    <article class="group flex gap-5">
                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" class="flex gap-5 w-full">
                            <figure class="aspect-video w-1/4 bg-gray-200 overflow-hidden">
                                <img src="{{ $article->featured_image_url ?? '/images/thumb-placeholder.jpg' }}"
                                    alt="Thumbnail for {{ $article->title }}" class="w-full h-full object-cover" loading="lazy" />
                            </figure>
                            <div class="flex-1">
                                <h2 class="text-md font-semibold text-gray-900 line-clamp-1 group-hover:underline">
                                    {{ $article->title }}
                                </h2>
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ $article->excerpt ?? Str::limit($article->content, 120) }}
                                </p>
                                <time datetime="{{ $article->published_at }}"
                                    class="text-xs text-gray-400 mt-1 inline-block">{{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</time>
                            </div>
                        </a>
                    </article>

                    @if ($loop->last)
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </section>

    <!-- Latest and Popular Articles Section -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-5 mb-12">
        <!-- Latest Articles -->
        <section class="col-span-2" aria-labelledby="latest-articles-heading">
            <div class="flex gap-2">
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true"><path fill="currentColor" d="M14 4V2H0v11a1 1 0 0 0 1 1h13.5a1.5 1.5 0 0 0 1.5-1.5V4h-2zm-1 9H1V3h12v10zM2 5h10v1H2zm6 2h4v1H8zm0 2h4v1H8zm0 2h3v1H8zM2 7h5v5H2z"/></svg>
                <div class="mb-8 group">
                    <h2 id="latest-articles-heading" class="text-xl font-black uppercase tracking-wider text-black mb-1">Latest</h2>
                    <div class="w-0 group-hover:w-12 duration-200 h-0.5 bg-black"></div>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ($articles as $article)
                    <article class="group block">
                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}">
                            <figure>
                                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                                    class="w-full aspect-video object-cover" loading="lazy">
                            </figure>
                            <h3 class="group-hover:underline font-semibold mt-2 line-clamp-2 text-md">{{ $article->title }}</h3>
                            <div class="flex items-center gap-1 text-xs text-gray-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <time datetime="{{ $article->published_at }}">{{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</time>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </section>

        <!-- Popular Articles -->
        <section aria-labelledby="popular-articles-heading">
            <div class="flex gap-2">
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" aria-hidden="true">
                    <path fill="#FF8F1F"
                        d="M266.91 500.44c-168.738 0-213.822-175.898-193.443-291.147c.887-5.016 7.462-6.461 10.327-2.249c8.872 13.04 16.767 31.875 29.848 30.24c19.661-2.458 33.282-175.946 149.807-224.761c3.698-1.549 7.567 1.39 7.161 5.378c-5.762 56.533 28.181 137.468 88.316 137.468c34.472 0 58.058-27.512 69.844-55.142c3.58-8.393 15.843-7.335 17.896 1.556c21.031 91.082 77.25 398.657-179.756 398.657z" />
                    <path fill="#FFB636"
                        d="M207.756 330.827c3.968-3.334 9.992-1.046 10.893 4.058c2.108 11.943 9.04 32.468 31.778 32.468c27.352 0 45.914-75.264 50.782-97.399c.801-3.642 4.35-6.115 8.004-5.372c68.355 13.898 101.59 235.858-48.703 235.858c-109.412 0-84.625-142.839-52.754-169.613zM394.537 90.454c2.409-18.842-31.987 32.693-31.987 32.693s26.223 12.386 31.987-32.693zM47.963 371.456c.725-8.021-9.594-29.497-11.421-20.994c-4.373 20.344 10.696 29.016 11.421 20.994z" />
                    <path fill="#FFD469"
                        d="M323.176 348.596c-2.563-10.69-11.755 14.14-10.6 24.254c1.155 10.113 16.731 1.322 10.6-24.254z" />
                </svg>
                <div class="mb-8 group">
                    <h2 id="popular-articles-heading" class="text-xl font-black uppercase tracking-wider text-black mb-1">Popular</h2>
                    <div class="w-0 group-hover:w-12 duration-200 h-0.5 bg-black"></div>
                </div>
            </div>

            <div>
                @foreach ($popularArticles as $article)
                    <article class="flex group gap-5 border-t border-gray-200 py-2 {{ $loop->last ? 'border-b' : '' }}">
                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" class="flex gap-5 w-full">
                            <div class="flex-shrink-0">
                                <span class="text-3xl font-black transition-colors {{ $loop->index < 1 ? 'text-red-500' : ($loop->index < 2 ? "text-green-500" : ($loop->index < 3 ? "text-yellow-500" : 'text-gray-300')) }} group-hover:text-black">
                                    {{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-md font-semibold text-gray-900 line-clamp-1 group-hover:underline">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-xs text-gray-600 line-clamp-2">
                                    {{ $article->excerpt ?? Str::limit($article->content, 120) }}
                                </p>
                                <div class="flex gap-1 text-xs text-gray-500 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <time datetime="{{ $article->published_at }}">{{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</time>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    </div>

    <!-- Category Sections -->
    <section>
        @foreach ($featuredCategories as $category)
            <section aria-labelledby="category-{{ $category->id }}-heading">
                <div class="pt-2 mb-6">
                    <div class="flex gap-2 mb-2">
                        <svg class="size-6" class="text-black" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 256 256" aria-hidden="true">
                            <path fill="currentColor"
                                d="M216 40H40a16 16 0 0 0-16 16v160a8 8 0 0 0 11.58 7.15L64 208.94l28.42 14.21a8 8 0 0 0 7.16 0L128 208.94l28.42 14.21a8 8 0 0 0 7.16 0L192 208.94l28.42 14.21A8 8 0 0 0 232 216V56a16 16 0 0 0-16-16Zm0 163.06l-20.42-10.22a8 8 0 0 0-7.16 0L160 207.06l-28.42-14.22a8 8 0 0 0-7.16 0L96 207.06l-28.42-14.22a8 8 0 0 0-7.16 0L40 203.06V56h176ZM136 112a8 8 0 0 1 8-8h48a8 8 0 0 1 0 16h-48a8 8 0 0 1-8-8Zm0 32a8 8 0 0 1 8-8h48a8 8 0 0 1 0 16h-48a8 8 0 0 1-8-8Zm-72 24h48a8 8 0 0 0 8-8V96a8 8 0 0 0-8-8H64a8 8 0 0 0-8 8v64a8 8 0 0 0 8 8Zm8-64h32v48H72Z" />
                        </svg>
                        <h2 id="category-{{ $category->id }}-heading" class="text-lg font-bold uppercase tracking-wider text-black">{{ $category->name }}</h2>
                    </div>
                    <div class="border-b border-gray-400 mb-4"></div>
                </div>

                @php
                    $articles = $category->articles()->where('status', 'published')->orderBy('published_at', 'desc')->get();
                @endphp

                @if ($articles->isNotEmpty())
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <!-- Left Column - Smaller Articles -->
                        <div class="lg:col-span-4 space-y-4">
                            @if ($articles->count() > 1)
                                @foreach ($articles->skip(1)->take(3) as $index => $article)
                                    <article class="border-b border-gray-300 pb-4 {{ $loop->last ? 'border-b-0' : '' }}">
                                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" class="block group">
                                            <time datetime="{{ $article->published_at }}"
                                                class="text-xs text-gray-400 font-bold mb-2">
                                                {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                            </time>

                                            <h3 class="font-bold text-black text-sm leading-tight mb-2 group-hover:underline">
                                                {{ $article->title }}
                                            </h3>

                                            <p class="text-xs text-gray-800 leading-relaxed line-clamp-3">
                                                {{ strip_tags($article->content) }}
                                            </p>
                                        </a>
                                    </article>
                                @endforeach
                            @endif
                        </div>

                        <!-- Center Column - Main Featured Article -->
                        <div class="lg:col-span-5 border-l border-r border-gray-300 px-6">
                            <article class="h-full">
                                <a href="{{ route('articles.show', ['slug' => $articles[0]->slug]) }}"
                                    class="block group h-full">
                                    <figure class="mb-4">
                                        <img src="{{ $articles[0]->featured_image_url }}"
                                            alt="{{ $articles[0]->title }}"
                                            class="w-full h-64 object-cover border border-gray-300" loading="lazy">
                                    </figure>

                                    <time datetime="{{ $articles[0]->published_at }}"
                                        class="text-xs text-gray-400 mb-3 font-bold">
                                        {{ \Carbon\Carbon::parse($articles[0]->published_at)->diffForHumans() }}
                                    </time>

                                    <h2 class="font-bold text-black text-xl leading-tight mb-4 group-hover:underline">
                                        {{ $articles[0]->title }}
                                    </h2>

                                    <p class="text-sm text-gray-800 leading-relaxed line-clamp-3">
                                        {!! strip_tags($articles[0]->content) !!}
                                    </p>
                                    <span class="text-sm text-blaco hover:underline font-medium">Read more...</span>
                                </a>
                            </article>
                        </div>

                        <!-- Right Column - Additional Articles -->
                        <div class="lg:col-span-3 space-y-4">
                            <div class="grid grid-cols-2 lg:grid-cols-1 gap-5 lg:gap-0">
                                @if ($articles->count() > 4)
                                @foreach ($articles->skip(4)->take(2) as $index => $article)
                                    <article class="border-b border-gray-300 pb-4 {{ $loop->last ? 'border-b-0' : '' }}">
                                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}"
                                            class="block group">
                                            @if ($loop->first)
                                                <figure>
                                                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full w-full aspect-video object-cover mb-2" loading="lazy">
                                                </figure>
                                            @else
                                                <figure class="lg:hidden">
                                                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full aspect-video object-cover mb-2" loading="lazy">
                                                </figure>
                                            @endif

                                            <time datetime="{{ $article->published_at }}"
                                                class="text-xs text-gray-400 font-bold mb-2">
                                                {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                            </time>

                                            <h3 class="font-bold text-black text-sm leading-tight mb-2 group-hover:underline">
                                                {{ $article->title }}
                                            </h3>

                                            <p class="text-xs text-gray-800 leading-relaxed line-clamp-3">
                                                {{ strip_tags($article->content) }}
                                            </p>
                                        </a>
                                    </article>
                                @endforeach
                            @endif
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        @endforeach
    </section>
</main>
@endsection