@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->meta_description ?? $article->excerpt ?? Str::limit(strip_tags($article->content), 150))

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
            <!-- Main Article Content -->
            <article class="lg:col-span-8 pr-0 lg:pr-12" itemscope itemtype="http://schema.org/Article">

                <!-- Category and Date -->
                <header class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="bg-black text-white px-4 py-1 text-xs font-bold uppercase tracking-widest" itemprop="articleSection">
                                {{ $article->category?->name }}
                            </div>
                        </div>
                        <time datetime="{{ $article->published_at }}" class="text-sm text-gray-500 font-medium" itemprop="datePublished">
                            {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                        </time>
                    </div>

                    <!-- Article Title -->
                    <h1 class="text-4xl font-black leading-none mb-8 text-black" itemprop="headline">
                        {{ $article->title }}
                    </h1>

                    <div class="flex items-center gap-6 py-2 border-y border-gray-100">
                        <span class="text-sm text-gray-600 font-semibold">SHARE</span>
                        <div class="flex gap-4">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" 
                                target="_blank" rel="noopener noreferrer"
                                class="text-gray-400 hover:text-[#1DA1F2] transition-colors"
                                aria-label="Share on Twitter">
                                <svg class="size-5" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M18.205 2.25h3.308l-7.227 8.26l8.502 11.24H16.13l-5.214-6.817L4.95 21.75H1.64l7.73-8.835L1.215 2.25H8.04l4.713 6.231l5.45-6.231Zm-1.161 17.52h1.833L7.045 4.126H5.078L17.044 19.77Z"/></svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                target="_blank" rel="noopener noreferrer"
                                class="text-gray-400 hover:text-[#4267B2] transition-colors"
                                aria-label="Share on Facebook">
                                <svg class="size-5" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5Z"/></svg>
                            </a>
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" 
                                target="_blank" rel="noopener noreferrer"
                                class="text-gray-400 hover:text-[#0088cc] transition-colors"
                                aria-label="Share on Telegram">
                                <svg class="size-5" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="m20.665 3.717l-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42l10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l.002.001l-.314 4.692c.46 0 .663-.211.921-.46l2.211-2.15l4.599 3.397c.848.467 1.457.227 1.668-.785l3.019-14.228c.309-1.239-.473-1.8-1.282-1.434z"/></svg>
                            </a>
                            <button onclick="copyCurrentURL()" 
                                class="text-gray-400 hover:text-gray-800 transition-colors cursor-pointer"
                                aria-label="Copy article link">
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m14.162 18.488l-.72.72a6.117 6.117 0 0 1-8.65-8.65l.72-.72m4.325 4.324l4.325-4.325M9.837 5.512l.721-.72a6.117 6.117 0 1 1 8.65 8.65l-.72.72"/></svg>
                            </button>
                        </div>
                    </div>
                </header>

                <!-- Featured Image -->
                <figure class="mb-6">
                    <div class="relative overflow-hidden bg-gray-100">
                        <img src="{{ $article->featured_image_url ?? '/images/placeholder.jpg' }}"
                            alt="{{ $article->title }}" class="w-full h-auto object-cover" loading="lazy" itemprop="image" />
                    </div>
                    <figcaption class="mt-4 italic text-sm text-gray-500">
                        " {{ $article->excerpt ?? $article->title }}
                    </figcaption>
                </figure>

                <!-- Article Content -->
                <div class="prose prose-lg max-w-none" itemprop="articleBody">
                    <div class="text-gray-900 leading-relaxed space-y-8">
                        {!! $article->content !!}
                    </div>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="lg:col-span-4 border-l border-gray-50 pl-0 lg:pl-12">
                <div class="">
                    <!-- Related Articles -->
                    <section class="mb-12 pt-6 lg:pt-0" aria-labelledby="related-articles-heading">
                        <div class="mb-8">
                            <h2 id="related-articles-heading" class="text-xl font-black uppercase tracking-wider text-black mb-2">Related</h2>
                            <div class="w-12 h-0.5 bg-black"></div>
                        </div>

                        <div>
                            @foreach ($relateArticles as $article)
                                <article class="flex items-start gap-4 border-b py-3 border-dotted border-gray-300">
                                    <div>
                                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}"
                                           class="hover:text-red-700 transition-colors">
                                            <h3 class="text-base font-bold leading-snug">
                                                {{ $article->title }}
                                            </h3>
                                        </a>
                                        <time datetime="{{ $article->published_at }}" class="text-xs text-gray-500 mt-1 italic">
                                            {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                        </time>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <!-- Trending Articles -->
                    <section class="bg-black text-white p-6 mt-6" aria-labelledby="trending-articles-heading">
                        <h3 id="trending-articles-heading" class="text-xl font-black uppercase tracking-wider mb-4 text-red-400">
                            Trending <span class="text-white">Now</span>
                        </h3>
                        <div class="space-y-4">
                            @foreach ($popularArticles as $index => $article)
                                <article class="flex items-start gap-3">
                                    <span class="text-2xl font-black text-red-600">{{ $index + 1 }}</span>
                                    <div>
                                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}"
                                            class="hover:text-red-400 transition-colors">
                                            <h4 class="text-sm font-bold leading-tight">
                                                {{ $article->title }}
                                            </h4>
                                        </a>
                                        <time datetime="{{ $article->published_at }}" class="text-xs text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                                        </time>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyCurrentURL() {
    navigator.clipboard.writeText(window.location.href);
    // Create alert element
    const alert = document.createElement('div');
    alert.innerHTML = `
        <div class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-black text-white px-6 py-3 flex items-center" style="z-index: 10000;">
            <span>Link copied to clipboard!</span>
        </div>
    `;
    document.body.appendChild(alert);

    // Remove alert after 2 seconds
    setTimeout(() => {
        alert.remove();
    }, 2000);
}
</script>
@endsection