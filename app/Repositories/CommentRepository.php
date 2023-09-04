<?php

namespace App\Repositories;


use App\Models\Comment;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository{
    public function create(array $attributes){
        return DB::transaction(function () use ($attributes){
            $created = Comment::query()->create([
                'body' => data_get($attributes, 'body'),
                'post_id' => data_get($attributes, 'post_id'),
                'user_id' => data_get($attributes, 'user_id')
            ]);
            return $created;
        });
    }

    public function update($comment, array $attributes){
        return DB::transaction(function () use($comment, $attributes) {
            $updated = $comment->update([
                'body' => data_get($attributes, 'body', $comment->body),
                'user_id' => data_get($attributes, 'user_id', $comment->user_id),
                'post_id' => data_get($attributes, 'post_id', $comment->post_id)
            ]);
            if(!$updated){
                throw new \Exception('Failed to update comment');
            }
            return $comment;
        });
    }

    public function forceDelete($comment){
        return DB::transaction(function () use($comment){
            $deleted = $comment->forceDelete();

            if(!$deleted){
                throw new \Exception('Cannot delete comment.');
            }
        });
    }
}
