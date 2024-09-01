<?php

namespace App\Admin\Controllers;

use App\Models\Registration;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\User;

class RegistrationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Registration';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Registration());

        $user = auth('admin')->user();
          //filter by name
       $grid->filter(function ($filter) 
       {
        // Remove the default id filter
        $filter->disableIdFilter();
        $filter->like('user_id', 'Applicant')->select(\App\Models\User::pluck('name', 'id'));
       
       });

       //remove the export and grid button
        $grid->disableExport();
        $grid->disableColumnSelector();

        $grid->model()->orderBy('created_at', 'desc');
       
      
         //show the user only his records
        if ($user->inRoles(['basic-user','garden_owner'])) 
        {
          
            $grid->model()->where('user_id', auth('admin')->user()->id);
            
            $registration= Registration::where('user_id', $user->id)->first();
            if(!$registration){
                return $grid;
            }

          //if registration exits disable create button
            if ($registration && !$user->isRole('administrator')) {
                $grid->disableCreateButton();
            }
            

            //disable delete and show action button
            $grid->actions(function ($actions) {
                if($actions->row->status == 1 || 
                $actions->row->status == 2)
                {
                    $actions->disableDelete();
                    $actions->disableEdit();
                }
            });
     
            $grid->column('user_id', __('Applicant'))->display(function ($user_id) {
                return User::find($user_id)->name;
            });

            $grid->column('category', __('Category'));

            if($registration->category == 'farmer'){
            $grid->column('first_name', __('Farmer\'s Name'))->display(function ($first_name) {
                return $first_name.' '.$this->middle_name.' '.$this->last_name;
            });
            $grid->column('farmers_group', __('Farmers group'));
            $grid->column('farming_experience', __('Farming experience'));
            $grid->column('production_scale', __('Production scale'));
            }

            if($registration->category == 'seed producer'){
            $grid->column('company_information', __('Enterprise name'));
            $grid->column('registration_number', __('Registration number'));
            $grid->column('registration_date', __('Registration date'));
            $grid->column('phone_number', __('Phone number'));
            $grid->column('district', __('District'));
            }

            if($registration->category == 'service provider'){
            $grid->column('service_provider_name', __('Service provider name'));
            $grid->column('registration_number', __('Registration number'));
            $grid->column('registration_date', __('Registration date'));
            $grid->column('physical_address', __('Physical address'));
            $grid->column('phone_number', __('Phone number'));
            $grid->column('services_offered', __('Services offered'));
            
            }
         
        }
        else
        {
            

            //disable delete and show action button
            $grid->actions(function ($actions) {
                $actions->disableDelete();
               
            });

            $grid->column('user_id', __('Applicant'))->display(function ($user_id) {
                return User::find($user_id)->name ?? '_';
            });

            $grid->column('category', __('Category'));
            //$grid->column('status', __('Status'))->editable('select', [0 => 'Pending', 1 => 'Approved', 2 => 'Rejected']);
       

        }

        $grid->column('status', __('Status'))->display(function ($status) {
            if($status == 0){
                return "<span class='label label-warning'>Pending</span>";
            }
            elseif($status == 1){
                return "<span class='label label-success'>Approved</span>";
            }
            elseif($status == 2){
                return "<span class='label label-danger'>Rejected</span>";
            }
        });

     

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
        $show = new Show(Registration::findOrFail($id));
        $registration = Registration::find($id);

        $show->field('user_id', __('Applicant'))->as(function ($user_id) {
            return User::find($user_id)->name;
        });
        $show->field('category', __('Category'));
        
        if($registration->category == 'farmer')
        {
            $show->field('first_name', __('Farmer\'s Name'))->as(function ($first_name) {
                return $first_name.' '.$this->middle_name.' '.$this->last_name;
            });
            $show->field('date_of_birth', __('Date of birth'));
            $show->field('level_of_education', __('Level of education'));
            $show->field('gender', __('Gender'));
            $show->field('sub_county', __('Sub county'));
            $show->field('parish', __('Parish'));
            $show->field('village', __('Village'));
            $show->field('farmers_group', __('Farmers group'));
            $show->field('farming_experience', __('Farming experience'));
            $show->field('production_scale', __('Production scale'));
            $show->field('number_of_dependants', __('Number of dependants'));

        }

        if($registration->category == 'seed producer')
        {
            $show->field('company_information', __('Enterprise name'));
            $show->field('registration_number', __('Registration number'));
            $show->field('registration_date', __('Registration date'));
            $show->field('phone_number', __('Phone number'));
            $show->field('district', __('District'));
            $show->field('parish', __('Parish'));
            $show->field('village', __('Village'));
            $show->field('farmers_group', __('Farmers group'));
            $show->field('farming_experience', __('Farming experience'));
            $show->field('production_scale', __('Production scale'));
            $show->field('specialization', __('Specialization'));
        }

        if($registration->category == 'service provider')
        {
            $show->field('service_provider_name', __('Service provider name'));
            $show->field('registration_number', __('Registration number'));
            $show->field('registration_date', __('Registration date'));
            $show->field('physical_address', __('Physical address'));
            $show->field('phone_number', __('Phone number'));
            $show->field('email_address', __('Email address'));
            $show->field('services_offered', __('Services offered'));
            $show->field('service_category', __('Service category'));
            $show->field('farming_experience', __('Farming experience'));
        }

        //disbale edit and delete button
        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
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
        $form = new Form(new Registration());
        $user = auth()->user();

        if ($form->isCreating()) {
            $form->hidden('user_id')->default($user->id);
            $this->displayApplicantField($form, $user);
            $this->displayCategorySpecificFields($form);
        }

        if ($form->isEditing() && !$user->isRole('basic-user')) 
        {
            $registration = Registration::find(request()->route()->parameter('registration'));
            $this-> displayCategorySpecificFields($form);
            if($registration->user_id != $user->id)
            {
               $this->displayStatusField($form);
            }
        }

        

        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();

        // Disable delete button
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        return $form;
    }

    protected function displayStatusField($form)
    {
        $form->divider();
        $form->radioButton('status', __('Status'))->options([
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Rejected'
        ])->default(0);
    }

    protected function displayApplicantField($form, $user)
    {
        $form->display('user_id', __('Applicant'))->default($user->name);
    }


    protected function displayCategorySpecificFields($form)
    {

    
        $form->radioCard('category', __('Category'))->options([
                'farmer' => 'Farmer',
                'seed producer' => 'Seed Producer',
                'service provider' => 'Service Provider'
                ])
        ->when('farmer', function(Form $form)
        {
            $user = auth()->user();
            //how to check the certain conditions to make a field readonly
            // $form->text('first_name', __('First name'))->attribute(
            //     ($form->isEditing() && $user->isRole('administrator')) ? 'readonly' : null
            // );
            
            
            $form->text('first_name', __('First name'))->rules('required');
            $form->text('middle_name', __('Middle name'))->rules('required');
            $form->text('last_name', __('Last name'))->rules('required');
            $form->date('date_of_birth', __('Date of birth'))->rules('required');
            $form->text('level_of_education', __('Level of education'))->rules('required');
            $form->text('phone_number', __('Phone number'))->rules(['required', 'regex:/^([0-9\s\-\+\(\)]*)$/']);
            $form->radio('gender', __('Sex'))->options([
                'female' => 'female',
                'male' => 'male'
                ])->rules('required');
            $form->text('sub_county', __('Sub county'))->rules('required');
            $form->text('parish', __('Parish'))->rules('required');
            $form->text('village', __('Village'))->rules('required');
            $form->text('farmers_group', __('Farmers Association group'))->rules('required');       
            $form->text('farming_experience', __('Farming experience'))->rules('required'); 
            $form->text('production_scale', __('Production scale'))->attribute('type', 'number')->rules('required');
            $form->text('number_of_dependants', __('Number of dependants'))->rules('required');


        })
        ->when('seed producer', function(Form $form)
        {
            $form->text('company_information', __('Enterprise Name'))->rules('required');
            $form->date('registration_date', __('Date of Registration'))->rules('required');
            $form->text('registration_number', __('Registration number'))->rules('required');
            $form->text('phone_number', __('Phone number'))->rules('required');
            $form->text('district', __('District of Operation'))->rules('required');
            $form->text('parish', __('Parish'))->rules('required');
            $form->text('village', __('Village'))->rules('required');
            $form->text('farmers_group', __('Farmers Association group'))->rules('required');
            $form->text('farming_experience', __('Years of experience'))->rules('required'); 
            $form->text('production_scale', __('Production scale'))->attribute('type', 'number')->rules('required');
            $form->text('specialization', __('Sector of Specialization'))->rules('required'); 
            

        })
        ->when('service provider', function(Form $form)
        {
            $form->text('service_provider_name', __('Service provider name'))->rules('required');
            $form->text('physical_address', __('Physical address'))->rules('required');
            $form->text('phone_number', __('Phone number'))->rules('required');
            $form->text('email_address', __('Email address'))->rules('required');
            $form->text('services_offered', __('Services offered'))->rules('required');
            $form->text('service_category', __('Service category'))->rules('required');
            $form->text('farming_experience', __('Years of experience'))->rules('required');
            $form->text('registration_number', __('Registration number'))->rules('required');
            $form->date('registration_date', __('Date of Registration'))->rules('required');

        })->required();
        
    }

}
