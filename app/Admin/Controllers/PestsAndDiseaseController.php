<?php

namespace App\Admin\Controllers;

use App\Models\PestsAndDisease;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PestsAndDiseaseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pests and Disease';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PestsAndDisease());
        $grid->model()->orderBy('id', 'desc');
        $grid->quickSearch();
        $grid->column('id', __('Sn'))->sortable();
        $grid->column('user_id', __('Owner'))->hide();
        $grid->column('category', __('Name'))->sortable();
        $grid->column('photo', __('Photo'))->image();
        $grid->column('video', __('Video'))->hide();
        $grid->column('audio', __('Audio'))->hide();
        $grid->column('description', __('Description'))->hide();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PestsAndDisease::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category', __('Category'));
        $show->field('garden_location', __('Garden location'));
        $show->field('user_id', __('User id'));
        $show->field('variety_id', __('Variety id'));
        $show->field('photo', __('Photo'));
        $show->field('video', __('Video'));
        $show->field('audio', __('Audio'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PestsAndDisease());

        /* $form->text('garden_location', __('Garden location'));
        $form->number('user_id', __('User id'));
        $form->number('variety_id', __('Variety id'));
        $form->text('photo', __('Photo'));
        $form->text('video', __('Video'));
        $form->text('audio', __('Audio')); */

        $form->text('category', __('name'))->rules('required');
        $form->image('photo', __('Photo'))->rules('required');
        $form->quill('description', __('Description'));

        return $form;
    }
}
