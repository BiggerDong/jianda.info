<?php

namespace App\Admin\Controllers;

use App\Question;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    public function warning()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->gridw());
        });
    }

    protected function gridw()
    {
        return Admin::grid(Question::class, function (Grid $grid) {

            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });
            $grid->model()->where('is_warning', 1);
            $grid->id('ID')->sortable();
            $grid->title('Title');
            $grid->user_id('UserId');
            $grid->is_hidden('Status');
            $grid->is_warning('Warning');
            $grid->followers_count('Followers');
            $grid->answers_count('Answers');
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Question::class, function (Grid $grid) {

            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->id('ID')->sortable();
            $grid->title('Title');
            $grid->user_id('UserId');
            $grid->is_hidden('Status');
            $grid->is_warning('Warning');
            $grid->followers_count('Followers');
            $grid->answers_count('Answers');
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Question::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', 'Title');
            $form->text('is_hidden', 'Status');
            $form->text('is_warning', 'Warning');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

}
