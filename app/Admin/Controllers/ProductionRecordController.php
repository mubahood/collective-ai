<?php

namespace App\Admin\Controllers;

use App\Models\ProductionRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductionRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ProductionRecord';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductionRecord());

        $grid->column('id', __('Id'));
        $grid->column('garden_id', __('Garden id'));
        $grid->column('activity_category', __('Activity category'));
        $grid->column('description', __('Description'));
        $grid->column('date', __('Date'));
        $grid->column('person_responsible', __('Person responsible'));
        $grid->column('remarks', __('Remarks'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(ProductionRecord::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('garden_id', __('Garden id'));
        $show->field('activity_category', __('Activity category'));
        $show->field('description', __('Description'));
        $show->field('date', __('Date'));
        $show->field('person_responsible', __('Person responsible'));
        $show->field('remarks', __('Remarks'));
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
        $form = new Form(new ProductionRecord());

        $form->number('garden_id', __('Garden id'));
        $form->text('activity_category', __('Activity category'));
        $form->text('description', __('Description'));
        $form->date('date', __('Date'))->default(date('Y-m-d'));
        $form->text('person_responsible', __('Person responsible'));
        $form->text('remarks', __('Remarks'));

        return $form;
    }
}
