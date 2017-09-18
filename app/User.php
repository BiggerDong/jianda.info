<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','uid', 'email', 'password', 'avatar','confirmation_token','auth_id','auth_type','api_token','is_hidden','settings'
    ];

    protected $allowed = ['city','school','company'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
      'settings' => 'json',
    ];

    public function merge(array $attributes)
    {
        $settings = array_merge($this->settings,array_only($attributes,$this->allowed));
        return $this->update(['settings' => $settings]);
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function follows()
    {
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }


    public function followst()
    {
        return $this->belongsToMany(Topic::class,'user_topic')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }

    public function followersi()
    {
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }

    public function followersUser()
    {
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }

    public function followed($question)
    {
        return !! $this->follows()->where('question_id',$question)->count();
    }

    public function followedt($topic)
    {
        return !! $this->followst()->where('topic_id',$topic)->count();
    }

    public function followThisQ($question)
    {
        return $this->follows()->toggle($question);
    }

    public function followThisT($topic)
    {
        return $this->followst()->toggle($topic);
    }

    public function followThisU($user)
    {
        return $this->followers()->toggle($user);
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    public function hasVoteFor($answer)
    {
        return !! $this->votes()->where('answer_id',$answer)->count();
    }

    /**
     * This Token used for resetting password
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }



}
