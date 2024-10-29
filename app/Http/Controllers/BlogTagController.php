<?php

namespace App\Http\Controllers;

use App\Models\BlogTag;
use App\Models\BlogTags;
use App\Http\Requests\StoreBlogTagsRequest;
use App\Http\Requests\UpdateBlogTagsRequest;

class BlogTagController extends Controller
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
    public function store(StoreBlogTagsRequest $request)
    {
        //
    }

    public function show(Tag $tag)
    {
        $page = 'portfolio_tag';
        $page_properties = PageProperty::where('page', $page)->first();
        $post = BlogPost::find($id);
        $latestPosts = BlogPost::orderBy('created_at', 'desc')->take(4)->get();
        $tags = BlogTag::all();
        return view('tags.show', [
            'post' => $post,
            'latestPosts' => $latestPosts,
            'tags' => $tags,
            'page'=>$page,
            'page_properties'=>$page_properties,
        ]);
        // Ambil semua post yang terkait dengan tag ini
        // $posts = $tag->posts()->paginate(10); // Gantilah dengan relasi yang sesuai
        // return view('tags.show', compact('tag', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogTags $blogTags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogTagsRequest $request, BlogTags $blogTags)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogTags $blogTags)
    {
        //
    }
}
