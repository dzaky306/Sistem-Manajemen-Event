<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected function authorizeAdmin()
    {
        abort_unless(auth()->user()?->is_admin, 403);
    }

    public function index()
    {
        $this->authorizeAdmin();
        $categories = Category::withCount('events')->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        
        $validated = $request->validate([
            'name' => 'required|max:50|unique:categories,name',
            'icon' => 'nullable|max:10',
            'description' => 'nullable|max:255',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $this->authorizeAdmin();
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeAdmin();
        
        $validated = $request->validate([
            'name' => 'required|max:50|unique:categories,name,' . $category->id,
            'icon' => 'nullable|max:10',
            'description' => 'nullable|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->authorizeAdmin();
        
        if ($category->events()->exists()) {
            return back()->with('error', 'Cannot delete category with existing events!');
        }
        
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}