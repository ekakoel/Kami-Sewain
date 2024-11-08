<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BlogTag;
use App\Models\BlogPost;
use App\Models\SocialLink;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Models\PageProperty;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    // USER
    public function user_index(Request $request)
    {
        $posts = BlogPost::with('author')->latest()->paginate(6);
        $page = 'portfolio';
        $page_properties = PageProperty::where('page', $page)->first();
        return view('blogs.index', compact(
            'posts',
            'page',
            'page_properties',
            ))->with('paginator', $posts);
    }
    public function show($id)
    {
        $page = 'portfolio_detail';
        $page_properties = PageProperty::where('page', $page)->first();
        $post = BlogPost::with(['comments.replies'])->findOrFail($id);
        $latestPosts = BlogPost::orderBy('created_at', 'desc')->take(4)->get();
        $categories = BlogCategory::all();
        $comments = $post->comments()->with('replies')->paginate(5);
        return view('blogs.show', compact('comments', 'post', 'latestPosts', 'categories', 'page', 'page_properties'));
    }

    // ADMIN
    public function index()
    {
        $posts = BlogPost::with('categories', 'tags', 'author')->paginate(10);
        return view('admin.portfolio.index', compact('posts'));
    }
    public function detail_portfolio($id)
    {
        $portfolio = BlogPost::findOrFail($id);
        return view('admin.portfolio.detail', compact('portfolio'));
    }
    public function edit_portfolio($id)
    {   
        $tags = BlogTag::all();
        $portfolio = BlogPost::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.portfolio.edit', compact('portfolio','categories','tags'));
    }

    public function create_portfolio()
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('admin.portfolio.create', compact('categories', 'tags'));
    }

    public function add_portfolio(Request $request)
{
    try {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'tags' => 'nullable|string',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
        ]);



        if ($request->hasFile('cover')) {
            $blogPost_featured_image = time() . '_featured_image_'.$request->title.".". $request->cover->getClientOriginalExtension();
            $request->cover->move('images/portfolio', $blogPost_featured_image,'publics');
            $blogPost->featured_image = $blogPost_featured_image;
        }

        // Create blog post
        $blogPost = BlogPost::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'featured_image' => $blogPost_featured_image ?? null,
            'category_id' => $request->category_id, // Set category_id
            'user_id' => auth('admin')->id(),
        ]);

        // Sync tags
        if ($request->has('tags')) {
            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags);
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag_slug = Str::slug($tagName);
                $tag = BlogTag::firstOrCreate([
                    'name' => $tagName,
                    'slug' => $tag_slug,
                ]);
                $tagIds[] = $tag->id;
            }
            $blogPost->tags()->sync($tagIds);
        } else {
            $blogPost->tags()->sync([]);
        }

        return redirect()->route('admin.portfolio')->with('success', 'Blog post created successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat post: ' . $e->getMessage());
    }
}

    public function edit($id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('admin.blogs.edit', compact('blogPost', 'categories', 'tags'));
    }


    public function update(Request $request, $id)
    {
        $currentDateTime = Carbon::now();

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'tags' => 'nullable|string',
            'meta_description' =>'required',
            'meta_keywords' =>'required',
            'featured_image' =>'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:2048', // Validasi gambar
            'status' =>'required',
        ]);

        // Temukan blog post berdasarkan ID
        $blogPost = BlogPost::findOrFail($id);
        $post_slug = Str::slug($request->title);
        
        if (empty($post_slug)) {
            $post_slug = $request->title.'-'.$request->categories.'-'.$id;
        }

        // Update fields
        $blogPost->title = $request->title;
        $blogPost->slug = $post_slug;
        $blogPost->content = $request->content;
        $blogPost->category_id = $request->category_id;
        $blogPost->meta_description = $request->meta_description;
        $blogPost->meta_keywords = $request->meta_keywords;
        $blogPost->status = $request->status;

        if ($request->status == 'published') {
            $blogPost->published_at = $currentDateTime;
        } else {
            $blogPost->published_at = NULL;
        }
        $directory = public_path('images/portfolio/');
        // Hapus gambar lama dan simpan gambar baru jika ada gambar baru yang di-upload
        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                $oldCoverPath = $directory . $blogPost->featured_image;
                if (file_exists($oldCoverPath)) {
                    unlink($oldCoverPath); // Menghapus file lama
                }
                // Storage::delete('images/products/' . $blogPost->featured_image);
            }
            $blogPost_featured_image = time() . '_featured_image_'.$blogPost->title.".". $request->featured_image->getClientOriginalExtension();
            $request->featured_image->move('images/portfolio', $blogPost_featured_image,'publics');
            $blogPost->featured_image = $blogPost_featured_image;
        }

        // Simpan perubahan
        $blogPost->save();

        // Tangani tags
        if ($request->has('tags')) {
            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags);
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag_slug = Str::slug($tagName);
                $tag = BlogTag::firstOrCreate([
                    'name' => $tagName,
                    'slug' => $tag_slug,
                ]);
                $tagIds[] = $tag->id;
            }
            $blogPost->tags()->sync($tagIds);
        } else {
            $blogPost->tags()->sync([]);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('admin.portfolio.detail', ['id' => $id])
                        ->with('success', 'Blog post updated successfully');
    }

    


    public function destroy($id)
    {
        $portfolio = BlogPost::find($id);
        if (!$portfolio) {
            return response()->json(['error' => 'Portfolio not found'], 404);
        }
        
        if (file_exists('images/portfolio/'.$portfolio->featured_image)) {
            unlink('images/portfolio/'.$portfolio->featured_image);
        }
        $portfolio->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Portfolio deleted successfully');
    }
}
