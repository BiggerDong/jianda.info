<?php
/**
 * Created by PhpStorm.
 * User: BiggerDong
 * Date: 2017/9/11
 * Time: 10:00
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }
}