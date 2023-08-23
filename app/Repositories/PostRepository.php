<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository{
    public function create(array $attributes){
        return DB::transaction(function () use ($attributes){
            $created = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body')
            ]);

            if($userId = data_get($attributes, 'user_id')){
                $created->users()->sync($userId);
            }
            return $created;
        });
    }

    public function update($post, array $attributes){
        return DB::transaction(function () use ($post, $attributes){
            $updated = $post->update([
                'title' => data_get($attributes, 'title', $post->title),
                'body' => data_get($attributes, 'body', $post->body)
            ]);
            if(!$updated){
                throw new \Exception('Failed to update post');
            }
            if($userId = data_get($attributes, 'user_id')){
                $post->users()->sync($userId);
            }
            return $post;
        });
    }

    public function forceDelete($post){
        return DB::transaction(function () use($post) {
            $deleted = $post->forceDelete();
            if(!$deleted){
                throw new \Exception("Cannot delete post.");
            }

            return $deleted;
        });
    }
}
