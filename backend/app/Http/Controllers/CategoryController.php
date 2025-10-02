<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $categories = $user->shop->categories()->paginate(20);
        return view('pages.shop_owner.category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.shop_owner.category.create', ['category' => new Category()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = auth()->user()->shop->categories()->create($request->validated());

        if (!$category) {
            return redirect()->back()->with('error', 'Category failed to create.');
        }

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('pages.shop_owner.category.create', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // You can implement edit logic here
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryStoreRequest $request, Category $category)
    {
        $updated = $category->update($request->validated());

        if (!$updated) {
            return redirect()->back()->with('error', 'Category failed to update.');
        }

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!$category->delete()) {
            return redirect()->back()->with('error', 'Category failed to delete.');
        }

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
