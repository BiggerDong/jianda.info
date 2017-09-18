<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Auth;

class UserFollowController extends Controller
{
    protected $userRepository;

    /**
     * FollowersController constructor.
     * @param $user
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isFollowed(Request $request)
    {
        $user = $this->userRepository->byId($request->get('user'));
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if (in_array(Auth::guard('api')->user()->id,$followers)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function followThisUser()
    {
        $me = Auth::guard('api')->user();
        $userToFollow = $this->userRepository->byId(request('user'));
        $followed = Auth::guard('api')->user()->followThisU($userToFollow->id);
        if (count($followed['attached']) > 0){
            $userToFollow->increment('followers_count');
            $me->increment('followings_count');
            $userToFollow->notify(new NewUserFollowNotification());
            return response()->json(['followed' => true]);
        }
        $userToFollow->decrement('followers_count');
        $me->decrement('followings_count');
        return response()->json(['followed' => false]);

    }
}
