<?php

namespace App\Admin\Controllers;

use App\Models\Crop;
use App\Models\Farmer;
use App\Models\Garden;
use App\Models\Parish;
use App\Models\User;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('name', 'Garden name');

            /* crop_id is select */
            $filter->equal('crop_id', 'Crop name')
                ->select(Crop::all()->pluck('name', 'id'));

            /* user_id is select */
            $filter->equal('user_id', 'Owner')
                ->select(User::all()->pluck('name', 'id'));

            /*             $filter->like('crop_id', 'Crop name');
            $filter->like('user_id', 'Owner');
            $filter->like('parish_id', 'Parish'); */
        });

        $grid->model()->orderBy('id', 'desc');
        $grid->quickSearch('name', 'id', 'crop_id', 'user_id', 'parish_id')
            ->placeholder('Search by name, crop, owner, parish');
        $grid->column('id', __('Sn'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('crop_id', __('Crop Planted'))
            ->display(function ($crop_name) {
                $crop = Crop::find($this->crop_id);
                if ($crop == null) {
                    return 'Unknown';
                }
                return $crop->name;
            })->sortable();

        $grid->column('production_scale', __('Production Scale'))
            ->sortable();
        $grid->column('planting_date', __('Planting Date'))
            ->display(function ($planting_date) {
                return Utils::my_date($planting_date);
            })->sortable();
        $grid->column('land_occupied', __('Land Occupied (Acres)'))->sortable();
        $grid->column('user_id', __('Owner'))
            ->display(function ($user_id) {
                $farmer = User::find($user_id);
                if ($farmer == null) {
                    return 'Unknown';
                }
                return $farmer->name;
            })->sortable();

        $grid->column('photo', __('Photo'))->hide();
        $grid->column('gps_lati', __('GPS'))
            ->display(function ($gps_lati) {
                return $this->gps_lati . ', ' . $this->gps_longi;
            })->sortable();
        $grid->column('harvest_date', __('Expected Harvest Date'))
            ->display(function ($harvest_date) {
                return Utils::my_date($harvest_date);
            })->sortable();
        $grid->column('is_harvested', __('Is Harvested'))
            ->display(function ($is_harvested) {
                return $is_harvested == 'Yes' ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
            })->sortable();
        $grid->column('harvest_quality', __('Harvest Quality'))->hide();
        $grid->column('quantity_harvested', __('Quantity harvested'))->hide();
        $grid->column('quantity_planted', __('Quantity planted'))->hide();
        $grid->column('harvest_notes', __('Harvest notes'))->hide();
        $grid->column('parish_id', __('Parish'))
            ->display(function ($parish_id) {
                $parish = Parish::find($parish_id);
                if ($parish == null) {
                    return 'Unknown';
                }
                return $parish->name_text;
            })->sortable();
        $grid->column('income', __('Income'))->hide();
        $grid->column('expense', __('Expense'))->hide();
        $grid->column('profit', __('Profit/Loss'))->hide();

        $grid->column('status', __('Garden Status'))
            ->display(function ($status) {
                return $status == 'Active' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
            })->sortable();
        $grid->column('created_at', __('Created'))
            ->display(function ($created_at) {
                return Utils::my_date($created_at);
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
        $show = new Show(Garden::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('crop_name', __('Crop name'));
        $show->field('status', __('Status'));
        $show->field('production_scale', __('Production scale'));
        $show->field('planting_date', __('Planting date'));
        $show->field('land_occupied', __('Land occupied'));
        $show->field('crop_id', __('Crop id'));
        $show->field('details', __('Details'));
        $show->field('user_id', __('User id'));
        $show->field('photo', __('Photo'));
        $show->field('gps_lati', __('Gps lati'));
        $show->field('gps_longi', __('Gps longi'));
        $show->field('harvest_date', __('Harvest date'));
        $show->field('is_harvested', __('Is harvested'));
        $show->field('harvest_quality', __('Harvest quality'));
        $show->field('quantity_harvested', __('Quantity harvested'));
        $show->field('quantity_planted', __('Quantity planted'));
        $show->field('harvest_notes', __('Harvest notes'));
        $show->field('district_id', __('District id'));
        $show->field('subcounty_id', __('Subcounty id'));
        $show->field('parish_id', __('Parish id'));
        $show->field('income', __('Income'));
        $show->field('expense', __('Expense'));
        $show->field('profit', __('Profit'));

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

        $form->saved(function (Form $form) {
            admin_toastr(__('Garden submitted successfully'), 'success');
            return redirect('/gardens');
        });
        $form->text('name', __('Garden name'))->rules('required');
        // $form->text('crop_name', __('Crop name'));
        $form->select('crop_id', __('Crop Planted'))
            ->options(Crop::all()->pluck('name', 'id'))
            ->rules('required');


        $form->select('user_id', 'Farm owner')
            ->options(Farmer::get_select_items())->rules('required');
        $form->radio('status', __('Garden Status'))
            ->options(['Active' => 'Active', 'Inactive' => 'Inactive'])
            ->default('Active')
            ->rules('required');

        $form->radio('production_scale', __('Production Scale'))
            ->options([
                'Small scale' => 'Small scale',
                'Medium scale' => 'Medium scale',
                'Large scale' => 'Large scale'
            ])->rules('required');

        $form->date('planting_date', __('Planting date'))->rules('required');
        $form->date('harvest_date', __('Expected Harvest date'))->rules('required');

        $form->decimal('land_occupied', __('Land Size in Acres'))->rules('required');
        $form->image('photo', __('Garden Photo'));
        $parihses = Parish::getDropDownList();
        $form->select('parish_id', __('Parish'))->options($parihses)->rules('required');
        $form->text('gps_lati', __('Gps latitude'));
        $form->text('gps_longi', __('Gps longitude'));
        $form->textarea('details', __('Farm Details'));

        $form->radio('is_harvested', __('Is harvested?'))
            ->default('No')
            ->options(['Yes' => 'Yes', 'No' => 'No'])
            ->when(
                'Yes',
                function (Form $form) {
                    $form->textarea('harvest_quality', __('Harvest quality'))->rules('required');
                    $form->number('quantity_harvested', __('Quantity harvested'))->rules('required');
                    $form->number('quantity_planted', __('Quantity planted'))->rules('required');
                    $form->textarea('harvest_notes', __('Harvest notes'));
                }
            );




        return $form;
    }
}
