<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::latest();
        if ($request->has('status') && in_array($request->status, ['draft', 'published', 'archived'])) {
            $query->where('status', $request->status);
        }

        // Type filter
        if ($request->has('type') && in_array($request->type, ['page', 'news', 'blog'])) {
            $query->where('type', $request->type);
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(10);
        return view('admin.articles.index', ['articles' => $articles]);
    }

    public function latest()
    {
        $articles = Article::where('type', 'news')
            ->where('status', 'published')
            ->latest()
            ->paginate(15);

        return view('pages.articles.latest', ['articles' => $articles]);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('type', 'news')
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $article->increment('view_count');

        // Get related articles, excluding the current one
        $relateArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('type', 'news')
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        $popularArticles = Article::where('status', "published")
            ->where('type', 'news')
            ->where('id', '!=', $article->id)
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        return view('pages.articles.show', [
            'article' => $article,
            'relateArticles' => $relateArticles,
            'popularArticles' => $popularArticles
        ]);
    }

    public function create(){
        $categories = Category::all();
        return view('admin.articles.create', ['categories' => $categories]);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'required',
            'featured_image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string'
        ]);

        $uploadImage = null;
        if ($request->hasFile('featured_image_url')) {
            $path = $request->file('featured_image_url')->store('articles', 'public');
            $uploadImage = asset('storage/' . $path);
        }

        $article = Article::create([
            'type' => $request->type,
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'featured_image_url' => $uploadImage,
            'status' => $request->status,
            'published_at' => $request->published_at,
            'author_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'meta_description' => $request->meta_description,
            'is_featured' => $request->has('is_featured')
        ]);

        // Handle tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            
            foreach ($tagNames as $index => $name) {
                if (!empty($name)) {
                    $tag = Tag::firstOrCreate(['name' => $name]);
                    $tagIds[$tag->id] = ['order' => $index];
                }
            }
            
            $article->tags()->sync($tagIds);
        }

        return redirect()->route('admin.articles.index')->with([
            'success' => "Article created successfully!"
        ]);
    }

    public function edit($id){
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('admin.articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'featured_image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string'
        ]);

        $article = Article::findOrFail($id);

        $data = $request->only([
            'type',
            'title',
            'excerpt',
            'content',
            'status',
            'published_at',
            'category_id',
            'meta_description',
        ]);

        $data['is_featured'] = $request->has('is_featured');

        // Handle image upload
        if ($request->hasFile('featured_image_url')) {
            // Delete old image if exists
            if ($article->featured_image_url) {
                $oldPath = str_replace(asset('storage/'), '', $article->featured_image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('featured_image_url')->store('articles', 'public');
            $data['featured_image_url'] = asset('storage/' . $path);
        }

        $article->update($data);

        // Handle tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            
            foreach ($tagNames as $index => $name) {
                if (!empty($name)) {
                    $tag = Tag::firstOrCreate(['name' => $name]);
                    $tagIds[$tag->id] = ['order' => $index];
                }
            }
            
            $article->tags()->sync($tagIds);
        } else {
            $article->tags()->sync([]);
        }

        return redirect()->route('admin.articles.index')->with([
            'success' => 'Article updated successfully!'
        ]);
    }

    public function destroy($id){
        Article::findOrFail($id)->delete();

        return redirect()->route('admin.articles.index')->with([
            'success' => "Article deleted successfully!"
        ]);
    }
}
