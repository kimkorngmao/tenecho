<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Article;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::orderBy('key')->orderBy('order')->get();
        return view('admin.site_settings.index', compact('settings'));
    }

    public function create()
    {
        $articles = Article::orderByRaw("CASE WHEN type = 'page' THEN 0 ELSE 1 END")->orderBy('type')->get();
        return view('admin.site_settings.create', compact('articles'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
            'article_id' => 'nullable|exists:articles,id',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = asset('storage/' . $path);
        }

        SiteSetting::create($data);

        return redirect()->route('admin.site-settings.index')->with('success', 'Site setting created successfully.');
    }

    public function edit($id)
    {
        $siteSetting = SiteSetting::findOrFail($id);
        $articles = Article::orderByRaw("CASE WHEN type = 'page' THEN 0 ELSE 1 END")->orderBy('type')->get();
        return view('admin.site_settings.edit', compact('siteSetting', 'articles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
            'article_id' => 'nullable|exists:articles,id',
        ]);
        
        $siteSetting = SiteSetting::findOrFail($id);
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($siteSetting->image) {
                $oldPath = str_replace(asset('storage/'), '', $siteSetting->image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            // Store new image
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = asset('storage/' . $path);
        }

        $siteSetting->update($data);

        return redirect()->route('admin.site-settings.index')->with('success', 'Site setting updated successfully.');
    }

    public function destroy($id)
    {
        $siteSetting = SiteSetting::findOrFail($id);
        $siteSetting->delete();
        return redirect()->route('admin.site-settings.index')->with('success', 'Site setting deleted successfully.');
    }
}
