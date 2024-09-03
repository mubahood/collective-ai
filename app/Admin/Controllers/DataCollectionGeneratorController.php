<?php

namespace App\Admin\Controllers;

use App\Models\DataCollectionGenerator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DataCollectionGeneratorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Data Collection Generators';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DataCollectionGenerator());
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('due_date', __('Due Date'))->sortable();
        $grid->column('do_generate', __('Do Generate'))
            ->display(function ($do_generate) {
                return $do_generate == 'Yes' ? 'Yes' : 'No';
            });
        //number of records
        $grid->column('records', __('Records'))->display(function () {
            return $this->price_records()->count();
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
        $show = new Show(DataCollectionGenerator::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('due_date', __('Due date'));
        $show->field('do_generate', __('Do generate'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DataCollectionGenerator());

        $form->date('due_date', __('Due date'))->default(date('Y-m-d'))->required();
        $form->radio('do_generate', __('Do generate'))
            ->options(['Yes' => 'Yes', 'No' => 'No'])
            ->default('Yes')
            ->required();

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}
