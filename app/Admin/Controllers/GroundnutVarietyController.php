<?php

namespace App\Admin\Controllers;

use App\Models\GroundnutVariety;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GroundnutVarietyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'GroundnutVariety';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GroundnutVariety());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('photo', __('Photo'))
            ->display(function ($avatar) {
                $img = url("storage/" . $avatar);
                return '<img class="img-fluid " style="border-radius: 10px;"  src="' . $img . '" >';
            })
            ->width(80)
            ->sortable();
        

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
        $show = new Show(GroundnutVariety::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('photo', __('Photo'))->image();
        $show->field('details', __('Details'));
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
        $form = new Form(new GroundnutVariety());

        $form->text('name', __('Name'));
        $form->image('photo', __('Photo'));
        $form->text('details', __('Details'));

        return $form;
    }
}
