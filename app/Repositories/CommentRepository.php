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

    public function update($post, array $attributes){

    }

    public function forceDelete($post){

    }
}
