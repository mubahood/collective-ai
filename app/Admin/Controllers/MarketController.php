<?php

namespace App\Admin\Controllers;

use App\Models\Market;
use App\Models\Parish;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MarketController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Markets';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Market());

        $grid->model()->orderBy('id', 'desc');
        $grid->column('image', __('Photo'))->image('', 50, 50)->sortable();
        $grid->quickSearch('name', 'description', 'address', 'gps')
            ->placeholder('Search by name, description, address, gps');
        $grid->column('name', __('Name'))->sortable();
        $grid->column('description', __('Description'))->hide();
        $grid->column('gps', __('Gps'))->sortable();
        $grid->column('address', __('Address'))->sortable();
        $grid->column('parish_id', __('Parish'))
            ->display(function ($parish_id) {
                if ($this->parish != null) {
                    return $this->parish->name_text;
                }
                return 'N/A';
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
        $show = new Show(Market::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('address', __('Address'));
        $show->field('gps', __('Gps'));
        $show->field('image', __('Image'));
        $show->field('parish_id', __('Parish id'));
        $show->field('subcounty_id', __('Subcounty id'));
        $show->field('district_id', __('District id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        // dd(Parish::first());
        $form = new Form(new Market());

        $form->text('name', __('Name'))->rules('required');

        $parihses = Parish::getDropDownList();
        $form->select('parish_id', __('Parish'))->options($parihses)->rules('required');
        $form->image('image', __('Image'));
        $form->text('address', __('Address'));
        $form->text('gps', __('Gps'));

        $form->textarea('description', __('Details'));
        return $form;
    }
}
