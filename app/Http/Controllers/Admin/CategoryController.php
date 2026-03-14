<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

// TODO: Add search/filter in categories admin section
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.categories.form', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '.webp';
            $image->move(public_path('uploads/categories'), $imageName);
            $data['image'] = $imageName;
        }

        Category::create($data);
        return redirect('/admin/categories')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view('admin.categories.form', compact('category', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($category->image && File::exists(public_path('/uploads/categories/' . $category->image))) {
                File::delete(public_path('/uploads/categories/' . $category->image));
            }
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '.webp';
            $image->move(public_path('uploads/categories'), $imageName);
            $data['image'] = $imageName;
        }

        $category->update($data);
        return redirect('/admin/categories')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        Category::where('parent_id', $id)->update(['parent_id' => null]);
        
        $category->delete();
        return redirect('/admin/categories')->with('success', 'Category deleted successfully');
    }
}
