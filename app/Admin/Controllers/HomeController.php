<?php

namespace App\Admin\Controllers;

use App\Vote;
use App\Answer;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Question;
use App\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Chart\Bar;
use Encore\Admin\Widgets\Chart\Doughnut;
use Encore\Admin\Widgets\Chart\Line;
use Encore\Admin\Widgets\Chart\Pie;
use Encore\Admin\Widgets\Chart\PolarArea;
use Encore\Admin\Widgets\Chart\Radar;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row(function ($row) {
                $users = User::count();
                $questions = Question::count();
                $answers = Answer::count();
                $comments = Comment::count();
                $votes = Vote::count();
                $notifications = DatabaseNotification::count();
                $waning = Question::where('is_warning',1)->count();
                $row->column(3, new InfoBox('用户', 'users', 'aqua', '/adminhere/users', $users));
                $row->column(3, new InfoBox('问题', 'question', 'green', '/adminhere/questions', $questions));
                $row->column(3, new InfoBox('话题', 'tag', 'blue', '/adminhere/topics', $questions));
                $row->column(3, new InfoBox('回答', 'file', 'yellow', '/adminhere/answers', $answers));
                $row->column(3, new InfoBox('评论', 'comment', 'purple', '/adminhere/comments', $comments));
                $row->column(3, new InfoBox('赞', 'thumbs-up', 'orange', '/adminhere/votes', $votes));
                $row->column(3, new InfoBox('通知', 'bell', '', '/adminhere/notifications', $notifications));
                $row->column(3, new InfoBox('举报', 'warning', 'red', '/adminhere/questions/warnings', $waning));
            });

        });
    }
}
