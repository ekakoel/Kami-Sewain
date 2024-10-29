<?php

namespace App\Http\Controllers;

use Log;
use App\Models\BlogPost;
use App\Models\BlogComment;
use App\Models\BlogComments;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogCommentsRequest;
use App\Http\Requests\UpdateBlogCommentsRequest;

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::with('comments')->get();
        $comments = BlogComment::with('user', 'admin', 'replies','posts')->get();
        return view('admin.comments.index', compact('comments','posts'));
    }
    public function detail_comment($id)
    {
        $post = BlogPost::findOrFail($id);
        $comments = BlogComment::with('user', 'admin', 'replies','posts')->get();
        return view('admin.comments.detail', compact('comments','post'));
    }
    
    public function approve($id)
    {
        $comment = BlogComment::find($id);
        if ($comment) {
            $comment->status = 'approved';
            $comment->save();
            
            return response()->json(['success' => 'Comment approved successfully!']);
        }

        return response()->json(['error' => 'Comment not found!'], 404);
    }

    public function reject($id)
    {
        $comment = BlogComment::find($id);
        if ($comment) {
            $comment->status = 'rejected';
            $comment->save();
            
            return response()->json(['success' => 'Comment rejected successfully!']);
        }

        return response()->json(['error' => 'Comment not found!'], 404);
    }
        
    public function destroy($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request, $postId)
    {
        Log::info($request->all());
        $validated = $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ]);

        BlogComment::create([
            'blog_post_id' => $postId,
            'user_id' => auth()->id(), // Mengambil ID pengguna yang sedang login
            'comment' => $validated['comment'],
            'status' => 'pending', // Atur status komentar (misalnya 'approved')
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Your comment is under review!');
    }

    // ADMIN COMMENT
    public function store_comment(Request $request, $postId)
    {
        Log::info($request->all());
        $validated = $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ]);

        BlogComment::create([
            'blog_post_id' => $postId,
            'admin_id' => auth('admin')->id(),
            'comment' => $validated['comment'],
            'status' => 'approved',
            'parent_id' => $validated['parent_id'] ?? null,
        ]);
        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function approveComment(Request $request)
    {
        dd($request->all());
        try {
            // Cari komentar berdasarkan ID yang dikirimkan via AJAX
            $reply = BlogComment::findOrFail($request->reply_id);
            
            // Set komentar sebagai approved
            $reply->status = 'approved';
            $reply->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Comment approved successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(BlogComments $blogComments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogComments $blogComments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCommentsRequest $request, BlogComments $blogComments)
    {
        //
    }

}
