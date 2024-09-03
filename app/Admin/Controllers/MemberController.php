<?php

namespace App\Admin\Controllers;

use App\Models\Market;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'System Users';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    protected function grid()
    {
        $userModel = config('admin.database.users_model');
        $grid = new Grid(new User());

        $grid->model()->orderBy('name', 'asc');
        $grid->quickSearch('username', 'name')->placeholder('Search by username, name');
        $grid->column('id', 'ID')->sortable();
        $grid->column('first_name', trans('admin.name'))
            ->display(function ($name) {
                $name = $this->first_name . ' ' . $this->last_name;
                $name = trim($name);
                if (strlen($name) < 1) {
                    return $this->name;
                }
                return $name;
            })->sortable();

        $grid->column('gender', __('Gender'))->sortable()->label([
            'Male' => 'info',
            'Female' => 'success',
        ]);
        $grid->column('phone_number', __('Phone number'))->sortable();
        $grid->column('email', __('Email'));
        $grid->column('avatar', __('Avatar'))->image('', 50, 50)->hide();
        $grid->column('created_at', __('Registered'))->sortable()
            ->display(function ($created_at) {
                return date('d-m-Y', strtotime($created_at));
            });


        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->getKey() == 1) {
                $actions->disableDelete();
            }
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('first_name', __('First name'));
        $show->field('middle_name', __('Middle name'));
        $show->field('last_name', __('Last name'));
        $show->field('username', __('Username'));
        $show->field('name', __('Name'));
        $show->field('gender', __('Gender'));
        $show->field('email', __('Email'));
        $show->field('phone_number', __('Phone number'));
        $show->field('avatar', __('Avatar'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
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
        $userModel = config('admin.database.users_model');
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');


        $form = new Form(new User());

        $form->text('first_name', __('First Name'))->rules('required');
        $form->text('last_name', __('Last name'))->rules('required');
        $form->text('phone_number', __('Phone number'))->rules('required');
        $form->radio('gender', __('Gender'))->options([
            'Male' => 'Male',
            'Female' => 'Female',
        ])->rules('required');


        $form->image('avatar', __('Photo'));
        if ($form->isCreating()) {
            $form->password('password', trans('admin.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });
        } else {
            $form->radio('change_password', 'Do you want to change password?')->options([
                'Yes' => 'Yes',
                'No' => 'No',
            ])->default('No')
                ->when('Yes', function (Form $form) {
                    $form->password('password', trans('admin.password'))->rules('required|confirmed');
                    $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                        ->default(function ($form) {
                            return $form->model()->password;
                        });
                });
        }



        $form->ignore(['password_confirmation', 'change_password']);

        $form->listbox('middle_name', 'Markets')
            ->options(Market::all()->pluck('name', 'id'));

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });



        /* 
                $form->text('username', __('Username'));
        $form->email('email', __('Email'));
        */

        return $form;
    }
}
