<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        //
    }

    public function show(BlogCategory $category)
    {
        $posts = $category->posts()->paginate(10);
        return view('blogs.categories.show', compact('category', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategories)
    {
        //
    }
}
