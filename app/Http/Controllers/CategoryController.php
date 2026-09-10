<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
         $user = Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to view this page.']);
        }
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
    public function catagory_add(){
        $user=Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to view this page.']);
        }
        return view('categories.create');
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        $category=new Category();
        $category->name=$request->name;
        $filename=$request->file('image')->store('categories', 'public');
        $category->image=$filename;
        $category->save();
        return redirect()->route('categories.index');
    }
    public function edit($id)
    {
        $user=Auth::user();
        if(!$user){
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to view this page.']);
        }
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
            }
            $filename = $request->file('image')->store('categories', 'public');
            $category->image = $filename;
        }
        
        $category->save();
        return redirect()->route('categories.index');
    }
    public function delete($id){
        $user=Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to view this page.']);
        }
        $category = Category::findOrFail($id);
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        return redirect()->route('categories.index');
    }
}
