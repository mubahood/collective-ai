<?php

namespace App\Admin\Controllers;

use App\Models\FinancialRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Garden;


class FinancialRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Financial Records';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FinancialRecord());

         //show a user only their gardens
         $user = auth()->user();
         //$grid->model()->where('user_id', $user->id);
 
         //filter by garden name
         $grid->filter(function($filter) use($user){
             //disable the default id filter
             $filter->disableIdFilter();

         });
 
         //disable  column selector
         $grid->disableColumnSelector();

         //disable export
         $grid->disableExport();

  
        $grid->column('garden_id', __('Garden'))->display(function($garden_id) {
            $G =  \App\Models\Garden::find($garden_id);
            if($G == null)
            {
                return "No Garden";
            }
        });
        $grid->column('category', __('Category'));
        $grid->column('amount', __('Amount'));
        $grid->column('date', __('Date'));
     
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
        $show = new Show(FinancialRecord::findOrFail($id));

    
        $show->field('garden_id', __('Garden'))->as(function ($garden_id) {
            $g = \App\Models\Garden::find($garden_id);
            if($g == null)
            {
                return "Garden does not exist";
            } 
            return \App\Models\Garden::find($garden_id)->name;
        });
      
        $show->field('category', __('Category'));
        $show->field('amount', __('Amount'));
        $show->field('payment_method', __('Payment method'));
        $show->field('recipient', __('Recipient'));
        $show->field('description', __('Description'));
        $show->field('receipt', __('Receipt'))->image();
        $show->field('date', __('Date'));
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
        $form = new Form(new FinancialRecord());

        
        $user = auth()->user();

        //When form is creating, assign user id
        if ($form->isCreating()) 
        {
            $form->hidden('user_id')->default($user->id);

        }

         //onsaved return to the list page
         $form->saved(function (Form $form) 
        {
            admin_toastr(__('Financial Record submitted successfully'), 'success');
            return redirect('/financial-records');
        });

        $form->select('garden_id', __('Garden')) 
        ->options(Garden::where('user_id', $user->id)->pluck('name', 'id'))
        ->required()->rules('required');
     
        $form->select('category', __('Type of Transaction'))->options([
            'Income' => 'Income',
            'Expenditure' => 'Expenditure',
        ])->required();
        $form->date('date', __('Date'))->default(date('Y-m-d'))->required();
        $form->text('description', __('Description'))->required();
        $form->text('recipient', __('From/to who'))->required();
        $form->decimal('amount', __('Amount'))->required();
        $form->text('payment_method', __('Means of Payment'))->required();
        $form->file('quantity', __('Quantity'))->required();

        return $form;
    }
}
