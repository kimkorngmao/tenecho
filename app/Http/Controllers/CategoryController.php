<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    public function index(){
        $categories = Category::orderBy('order', 'desc')->get();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function show($slug){
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('pages.categories.show', ['category' => $category]);
    }

    public function create(){
        $parentCategories = Category::whereNull('parent_id')->get();
        $lastCategory = Category::orderBy('order', 'desc')->first();
        return view('admin.categories.create', [
            'parentCategories' => $parentCategories,
            'newOrder' => $lastCategory ? $lastCategory->order + 1 : 1
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'order' => 'required|integer|min:1'
        ]);
        DB::transaction(function () use ($request) {
            Category::shiftOrder($request->order);
            Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'is_featured' => $request->has('is_featured'),
                'order' => $request->order
            ]);
        });
        return redirect()->route('admin.categories.index')->with([
            'success' => 'Category created successfully.'
        ]);
    }

    public function edit($id){
        $category = Category::findOrFail($id);
        $category['order'] = $category->order ?? 1; // Ensure order is set
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.edit', [
            'category' => $category,
            'parentCategories' => $parentCategories
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'order' => 'required|integer|min:1'
        ]);
        $category = Category::findOrFail($id);
        DB::transaction(function () use ($request, $category) {
            $category->shiftOrder($request->order);

            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'is_featured' => $request->has('is_featured'),
                'order' => $request->order
            ]);
        });

        return redirect()->route('admin.categories.index')->with([
            'success' => 'Category updated successfully.'
        ]);
    }

    public function destroy($id){
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with([
            'success' => 'Category deleted successfully.'
        ]);
    }
}
