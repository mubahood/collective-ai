<?php

namespace App\Admin\Controllers;

use App\models\WebUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WebUsersController extends AdminController
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
        $grid->column('created_at', __('Created at'))->hide();
        $grid->column('updated_at', __('Updated at'))->hide();
        $grid->column('location', __('Location'));
        $grid->column('commodity', __('Commodity'));
        $grid->column('units', __('units'));
        $grid->column('supplier_cost', __('Supplier cost'));
        $grid->column('supplier_difficulty', __('supplier_difficulty'))
        ->display(function ($demand) {
            $bgColor = 'bg-dark';
            if ($demand == 'Low') {
                $bgColor = 'bg-danger';
            } elseif ($demand == 'Medium') {
                $bgColor = 'bg-warning';
            } elseif ($demand == 'High') {
                $bgColor = 'bg-success';
            }
            return "<span class='badge $bgColor'>$demand</span>";
        })->sortable()
        ->filter([
            'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
        ]);

        $grid->column('retail_price', __('Retail price'));
        $grid->column('demand', __('Demand'))
        ->display(function ($demand) {
            $bgColor = 'bg-dark';
            if ($demand == 'Low') {
                $bgColor = 'bg-danger';
            } elseif ($demand == 'Medium') {
                $bgColor = 'bg-warning';
            } elseif ($demand == 'High') {
                $bgColor = 'bg-success';
            }
            return "<span class='badge $bgColor'>$demand</span>";
        })->sortable()
        ->filter([
            'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
        ]);

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
      $show->field('units', __('units'));
        $show->field('commodity', __('Commodity'));
        $show->field('supplier_cost', __('Supplier cost'));
        $show->field('supplier_difficulty', __(' supplier_difficulty'));
        $show->field('retail_price', __('Retail price'));
        $show->field('demand', __('Demand'));

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
       $form->text('units', __('units'));
        $form->number('supplier_cost', __('Supplier cost'));
        $form->radio('supplier_difficulty', __('supplier_difficulty'))->options(
            [
             'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
            ]
        );
        $form->number('retail_price', __('Retail price'));
        $form->radio('demand', __('Demand'))->options(
            [
             'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
            ]
        );
        return $form;
    }
}  
