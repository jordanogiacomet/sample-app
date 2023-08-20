<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $pageSize = $request->page_size ?? 20;
        $comments = Comment::query()->pagination($pageSize);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'body' => 'required|string',
            'post_id' => 'required|exists:posts,id'
        ]);


        $userId = auth()->id();

        $comment = Comment::create([
            'body' => $validatedData['body'],
            'user_id' => $userId,
            'post_id' => $validatedData['post_id']
        ]);


        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $updated = $comment->update([
            'body' => $request->body ?? $comment->title,
            'user_id' => $request->user_id ?? $comment->user_id,
            'post_id' => $request->post_id ?? $comment->post_id
        ]);

        if(!$updated){
            return new JsonResponse([
                'error' => [
                    'Failed to update model.'
                ]
            ], 400);
        }

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $deleted = $comment->forceDelete();


        if(!$deleted){
            return new JsonResponse([
                'error' => 'Could not delete resource.'
            ], 400);
        }

        return new JsonResponse([
            'data' => 'success'
         ], 200);
    }
}
