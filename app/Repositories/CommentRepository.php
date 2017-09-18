<?php
/**
 * Created by PhpStorm.
 * User: BiggerDong
 * Date: 2017/8/18
 * Time: 22:15
 */

namespace App\Repositories;


use App\Comment;

class CommentRepository
{
    public function create(array $attributes)
    {
        return Comment::create($attributes);
    }
}