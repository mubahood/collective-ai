<?php

namespace App\Admin\Controllers;

use App\Models\Commodity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommodityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Commodities';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Commodity());
        $grid->quickSearch('name', 'description')->placeholder('Search by name, description');

        $grid->model()->orderBy('name', 'asc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('image', __('Image'))->image('', 50, 50)->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('description', __('Description'))->hide();
        $grid->column('unit', __('Unit'))->sortable();
        $grid->column('min_price', __('Min Price'))->sortable()
            ->display(function ($min_price) {
                return 'UGX ' . number_format($min_price);
            });
        $grid->column('max_price', __('Max Mrice'))->sortable()
            ->display(function ($min_price) {
                return 'UGX ' . number_format($min_price);
            });
        $grid->column('avg_price', __('Avg Price'))->sortable()
            ->display(function ($min_price) {
                return 'UGX ' . number_format($min_price);
            });
        $grid->column('current_price', __('Current price'))
            ->display(function ($min_price) {
                return 'UGX ' . number_format($min_price);
            })->sortable();
        $grid->column('price_direction', __('Price Direction'))
            ->display(function ($price_direction) {
                $bgColor = 'bg-dark';
                if ($price_direction == 'Stable') {
                    $bgColor = 'bg-dark';
                } elseif ($price_direction == 'Rising') {
                    $bgColor = 'bg-success';
                } elseif ($price_direction == 'Falling') {
                    $bgColor = 'bg-danger';
                }
                return "<span class='badge $bgColor'>$price_direction</span>";
            })->sortable();

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
        $show = new Show(Commodity::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'));
        $show->field('description', __('Description'));
        $show->field('unit', __('Unit'));
        $show->field('min_price', __('Min price'));
        $show->field('max_price', __('Max price'));
        $show->field('avg_price', __('Avg price'));
        $show->field('current_price', __('Current price'));
        $show->field('price_direction', __('Price direction'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Commodity());

        $form->text('name', __('Name'))->rules('required');
        $form->text('unit', __('Standard Measurement Unit'))->rules('required');
        $form->image('image', __('Image'));
        $form->textarea('description', __('Description'));
        /*         $form->number('min_price', __('Min price'));
        $form->number('max_price', __('Max price'));
        $form->number('avg_price', __('Avg price'));
        $form->number('current_price', __('Current price'));
        $form->text('price_direction', __('Price direction'))->default('Stable'); */

        return $form;
    }
}
