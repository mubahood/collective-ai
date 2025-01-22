<?php

namespace App\Admin\Controllers;

use App\Models\WebUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WebUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'WebUser';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WebUser());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('location', __('Location'));
        $grid->column('commodity', __('Commodity'));
        $grid->column('supplier_cost', __('Supplier cost'));
        $grid->column('retail_price', __('Retail price'));
        $grid->column('demand', __('Demand'));
        $grid->column('units', __('Units'));
        $grid->column('supplier_difficulty', __('Supplier difficulty'));

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
        $show = new Show(WebUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('location', __('Location'));
        $show->field('commodity', __('Commodity'));
        $show->field('supplier_cost', __('Supplier cost'));
        $show->field('retail_price', __('Retail price'));
        $show->field('demand', __('Demand'));
        $show->field('units', __('Units'));
        $show->field('supplier_difficulty', __('Supplier difficulty'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WebUser());

        $form->text('location', __('Location'));
        $form->text('commodity', __('Commodity'));
        $form->number('supplier_cost', __('Supplier cost'));
        $form->number('retail_price', __('Retail price'));
        $form->text('demand', __('Demand'));
        $form->text('units', __('Units'));
        $form->text('supplier_difficulty', __('Supplier difficulty'));

        return $form;
    }
}
