<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $posts = Post::query()->paginate($pageSize);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $created = DB::transaction(function () use ($request){
            $created = Post::query()->create([
                'title' => $request->title,
                'body' => $request->body
            ]);
            $created->users()->sync([$request->user_id]);
            return $created;
        });

        return new PostResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $updated = $post->update([
            'title' => $request->title ?? $post->title,
            'body' => $request->body ?? $post->body
        ]);

        if(!$updated){
            return new JsonResponse([
                'error' => [
                    'Failed to update model.'
                ]
            ], 400);
        }

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $deleted = $post->forceDelete();


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
