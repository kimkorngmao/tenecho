<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Carbon;

class PageController extends Controller
{
    public function index()
    {
        // where('status', 'is_public')
        $featuredArticles = Article::where('is_featured', 1)
        ->where('status', "published")
        ->where('type', 'news')
        ->orderBy('published_at', 'desc')->take(4)->get();

        $popularArticles = Article::where('status', "published")
        ->where('type', 'news')
        ->orderBy('view_count', 'desc')->take(5)->get();

        $articles =  Article::where('status', "published")
        ->where('type', 'news')
        ->orderBy('published_at', 'desc')->take(6)->get();

        $featuredCategories = Category::where('is_featured', 1)->get();

        return view('pages.index', [
            'featuredArticles' => $featuredArticles,
            'popularArticles' => $popularArticles,
            'articles' => $articles,
            'featuredCategories' => $featuredCategories
        ]);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', "published")
            ->where('type', 'page')
            ->orWhere('type', 'standalone')
            ->firstOrFail();

        // Increment view count
        $article->increment('view_count');


        return view('pages.show', [
            'article' => $article
        ]);
    }

    public function search(Request $request){
        $query = $request->input('query');
        $articles = Article::where('status', "published")
            ->where('type', 'news')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('pages.search', [
            'articles' => $articles,
            'query' => $query
        ]);
    }

    public function dashboard(){
        $userCount = User::count();
        $articleCount = Article::count();
        $categoryCount = Category::count();
        $roleCount =Role::count();
        $recentArticles = Article::latest()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboards.index',[
            'userCount' => $userCount,
            'categoryCount' => $categoryCount,
            'articleCount' => $articleCount,
            'roleCount' => $roleCount,
            'recentArticles' => $recentArticles
        ]);
    }
}
