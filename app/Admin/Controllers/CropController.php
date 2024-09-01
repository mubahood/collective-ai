<?php

namespace App\Admin\Controllers;

use App\Models\Crop;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CropController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Groundnut Varieties';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Crop());
        $grid->disableBatchActions();

        $grid->column('photo', __('Photo'))
            ->display(function ($avatar) {
                $img = url("storage/" . $avatar);
                return '<img class="img-fluid " style="border-radius: 10px;"  src="' . $img . '" >';
            })
            ->width(80)
            ->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('details', __('Details'))->hide();

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
        $show = new Show(Crop::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('photo', __('Photo'));
        $show->field('details', __('Details'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Crop());

        $form->text('name', __('Name'))->required();
        $form->image('photo', __('Photo'))->required();
        $form->quill('details', __('Details'))->required();
        //$form->divider('Production Guides');
       
        $form->disableCreatingCheck();
        $form->disableViewCheck();
      

        return $form;
    }
}
