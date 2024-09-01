<?php

namespace App\Admin\Controllers;

use App\Models\Crop;
use App\Models\Garden;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\GroundnutVariety;

class GardenController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Garden';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Garden());
        //show a user only their gardens
        $user = auth()->user();
        $grid->model()->where('user_id', $user->id);

        //filter by garden name
        $grid->filter(function ($filter) {
            //disable the default id filter
            $filter->disableIdFilter();
            $filter->like('name', 'Garden name');
        });

        //disable  column selector
        $grid->disableColumnSelector();

        $grid->column('name', __('Garden name'));
        $grid->column('garden_size', __('Garden size(in acres)'));
        $grid->column('crop_id', __('Variety'))->display(function ($variety_id) {
            $var = Crop::find($variety_id);
            if ($var == null) {
                return $variety_id;
            }
            return $var->name;
        });
        $grid->column('seed_class', __('Seed class'));


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
        $show = new Show(Garden::findOrFail($id));


        $show->field('name', __('Garden name'));
        $show->field('garden_size', __('Garden size(in acres)'));
        $show->field('ownership', __('Ownership of land'));
        $show->field('planting_date', __('Planting date'));
        $show->field('harvest_date', __('Expected harvest date'));
        $show->field('variety_id', __('Groundnut variety planted'))->as(function ($variety_id) {
            return GroundnutVariety::find($variety_id)->name;
        });
        $show->field('seed_class', __('Seed class'));
        $show->field('certified_seller', __('Bought from certified seller'))->as(function ($certified_seller) {
            return $certified_seller ? 'Yes' : 'No';
        });
        $show->field('name_of_seller', __('Name of seller'))->as(function ($value) {
            return $value ?? '-';
        });
        $show->field('seller_location', __('Seller location'))->as(function ($value) {
            return $value ?? '-';
        });
        $show->field('seller_contact', __('Seller contact'))->as(function ($value) {
            return $value ?? '-';
        });
        $show->field('purpose_of_seller', __('Purpose of seller'))->as(function ($value) {
            return $value ?? '-';
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Garden());
        $user = auth()->user();

        //When form is creating, assign user id
        if ($form->isCreating()) {
            $form->hidden('user_id')->default($user->id);
        }

        //onsaved return to the list page
        $form->saved(function (Form $form) {
            admin_toastr(__('Garden submitted successfully'), 'success');
            return redirect('/gardens');
        });

        $form->text('name', __('Garden name'))->required();
        $form->decimal('garden_size', __('Garden size(In Acres)'))->required();
        $form->text('ownership', __('Ownership of land'))->required();
        $form->date('planting_date', __('Planting date'))->required();
        $form->date('harvest_date', __('Expected harvest date'))->required();
        $form->select('variety_id', __('Groundnut variety planted'))
            ->options(GroundnutVariety::all()->pluck('name', 'id'))
            ->required()->rules('required');
        $form->text('seed_class', __('Seed class'))->required();
        $form->radioButton('certified_seller', __('Bougth from certified seller?'))
            ->options(['1' => 'Yes', '0' => 'No'])
            ->when(
                1,
                function (Form $form) {
                    $form->text('name_of_seller', __('Name of seller'))->required();
                    $form->text('seller_location', __('Seller location'))->required();
                    $form->text('seller_contact', __('Seller contact'))->rules('required|numeric');
                    $form->text('purpose_of_seller', __('Purpose of seller'));
                }
            )->required();

        return $form;
    }
}
