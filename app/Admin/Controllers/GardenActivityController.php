<?php

namespace App\Admin\Controllers;

use App\Models\GardenActivity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Garden;

class GardenActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'GardenActivity';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GardenActivity());
        //show a user only their gardens
        $user = auth()->user();
        $grid->model()->where('user_id', $user->id);

         //filter by garden name
         $grid->filter(function($filter) use($user){
            //disable the default id filter
            $filter->disableIdFilter();
            $filter->like('garden_id', 'Garden name')->select(Garden::where('user_id', $user->id)->pluck('name', 'id'));
        });
        
        //disable  column selector
        $grid->disableColumnSelector();

      
        $grid->column('garden_id', __('Garden'))->display(function ($garden_id) {
            $g = \App\Models\Garden::find($garden_id);
            if($g == null)
            {
                return "No Garden";
            } 
            return \App\Models\Garden::find($garden_id)->name;
        });
        $grid->column('activity_category', __('Activity category'));
        $grid->column('person_responsible', __('Person responsible'));
      

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
        $show = new Show(GardenActivity::findOrFail($id));

        $show->field('garden_id', __('Garden'))->as(function ($garden_id) {
            $g = \App\Models\Garden::find($garden_id);
            if($g == null)
            {
                return "No Garden";
            } 
            return \App\Models\Garden::find($garden_id)->name;
        });
        $show->field('activity_category', __('Activity category'));
        $show->field('description', __('Description'));
        $show->field('date', __('Date'));
        $show->field('person_responsible', __('Person responsible'));
        $show->field('remarks', __('Remarks'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GardenActivity());

        $user = auth()->user();

        //When form is creating, assign user id
        if ($form->isCreating()) 
        {
            $form->hidden('user_id')->default($user->id);

        }

         //onsaved return to the list page
         $form->saved(function (Form $form) 
        {
            admin_toastr(__('Garden activity submitted successfully'), 'success');
            return redirect('/garden-activities');
        });

        $form->select('garden_id', __('Garden')) 
            ->options(Garden::where('user_id', $user->id)->pluck('name', 'id'))
            ->required()->rules('required');
     
        $form->select('activity_category', __('Activity category'))->options([
            'Planting' => 'Planting',
            'Weeding' => 'Weeding',
            'Fertilizer application' => 'Fertilizer application',
            'Pesticide application' => 'Pesticide application',
            'Harvesting' => 'Harvesting',
            'Other' => 'Other'
        ])->rules('required');
        $form->text('description', __('Description'));
        $form->date('date', __('Date'))->default(date('Y-m-d'))->required();
        $form->text('person_responsible', __('Person responsible'))->required();
        $form->text('remarks', __('Remarks'));

        return $form;
    }
}
