<?php

namespace App\Admin\Controllers;

use App\Models\ServiceProvider;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ServiceProviderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Service Providers';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ServiceProvider());
        $grid->model()->orderBy('id', 'desc');
        $grid->quickSearch();
        $grid->column('provider_name', __('Provider Name'))->sortable();
        $grid->column('business_name', __('Business name'))->sortable();
        $grid->column('details', __('Details'))->hide();
        $grid->column('services_offered', __('Services offered'));
        $grid->column('gps_lat', __('Gps lat'));
        $grid->column('gps_long', __('Gps long'));
        $grid->column('photo', __('Photo'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('phone_number_2', __('Phone number 2'));
        $grid->column('email', __('Email'));

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
        $show = new Show(ServiceProvider::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('provider_name', __('Provider name'));
        $show->field('business_name', __('Business name'));
        $show->field('details', __('Details'));
        $show->field('services_offered', __('Services offered'));
        $show->field('gps_lat', __('Gps lat'));
        $show->field('gps_long', __('Gps long'));
        $show->field('photo', __('Photo'));
        $show->field('phone_number', __('Phone number'));
        $show->field('phone_number_2', __('Phone number 2'));
        $show->field('email', __('Email'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ServiceProvider());
        $form->text('provider_name', __('Provider Name'))
            ->rules('required');
        $form->text('business_name', __('Business Name'))
            ->rules('required');
        $form->tags('services_offered', __('Services offered'));
        $form->quill('details', __('Details'));
        $form->decimal('gps_lat', __('GPS latitude'));
        $form->decimal('gps_long', __('Gps longitude'));
        $form->image('photo', __('Businness Photo'));
        $form->text('phone_number', __('Phone number'));
        $form->text('phone_number_2', __('Phone number 2'));
        $form->email('email', __('Email'));

        return $form;
    }
}
