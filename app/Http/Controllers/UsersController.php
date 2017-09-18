<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionFollow;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;

class UsersController extends Controller
{
    protected $userRepository;

    /**
     * UsersController constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }


    public function home($id)
    {
        $me = Auth::user();
        $user = $this->userRepository->byId($id);
        return view('users.home',compact('me','user'));
    }

    public function answers($id)
    {
        $me = Auth::user();
        $user = $this->userRepository->byId($id);
        return view('users.answer',compact('me','user'));
    }

    public function followq($id)
    {
        $me = Auth::user();
        $user = $this->userRepository->byId($id);
        $info = User::where('id',$id)->with(['follows'])->get();
        return view('users.followq',compact('me','user','info'));
    }

    public function followt($id)
    {
        $me = Auth::user();
        $user = $this->userRepository->byId($id);
        $info = User::where('id',$id)->with(['followst'])->get();
        return view('users.followt',compact('me','user','info'));
    }

    public function following($id)
    {
        $me = Auth::user();
        $user = $this->userRepository->byId($id);
        $info = User::where('id',$id)->with(['followers'])->get();
        return view('users.following',compact('me','user','info'));
    }

    public function follower($id)
    {
        $me = Auth::user();
        $user = $this->userRepository->byId($id);
        $info = User::where('id',$id)->with(['followersi'])->get();
        return view('users.follower',compact('me','user','info'));
    }

    public function edit()
    {
        return view('users.profile');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|max:12',
        ]);

        Auth::user()->merge($request->all());
        Auth::user()->update([
            'name' => $request->get('name'),
        ]);
        $user_id = Auth::id();
        return redirect()->route('userhome',[$user_id]);
    }

    public function changeAvatar(Request $request)
    {
        $file = $request->file('img');
        $filename = 'avatars/'.md5(time().Auth::user()->id).'.'.$file->getClientOriginalExtension();
        Storage::disk('qiniu')->writeStream($filename,fopen($file->getRealPath(),'r'));

        Auth::user()->avatar = 'http://'.config('filesystems.disks.qiniu.domain').'/'.$filename;
        Auth::user()->save();

        return ['url' => Auth::user()->avatar];
    }
}
