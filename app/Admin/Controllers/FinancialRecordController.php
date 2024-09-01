<?php

namespace App\Admin\Controllers;

use App\Models\FinancialRecord;
use App\Models\Garden;
use App\Models\User;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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
        $grid->column('id', __('Sn'))->sortable();
        $grid->column('created_at', __('Created'))
            ->display(function ($created_at) {
                return Utils::my_date($created_at);
            })->sortable();
        $grid->column('garden_id', __('Garden'))
            ->display(function ($garden_id) {
                $garden = Garden::find($garden_id);
                if ($garden == null) {
                    return 'Unknown';
                }
                return $garden->name;
            })->sortable();

        $grid->column('category', __('Type'))
            ->label([
                'Income' => 'success',
                'Expense' => 'danger',
            ])->sortable();
        $grid->column('description', __('Particulars'))->sortable();
        $grid->column('amount', __('Amount'))
            ->display(function ($amount) {
                return 'UGX ' . number_format($amount);
            })->sortable();
        $grid->column('payment_method', __('Payment method'))->hide();
        $grid->column('recipient', __('Recipient'))->hide();
 
        $grid->column('date', __('Date'))->sortable(); 

        $grid->column('user_id', __('Created By'))
            ->display(function ($user_id) {
                $user = User::find($user_id);
                if ($user == null) {
                    return 'Unknown';
                }
                return $user->name;
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
        $show = new Show(FinancialRecord::findOrFail($id));

        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('id', __('Id'));
        $show->field('garden_id', __('Garden id'));
        $show->field('user_id', __('User id'));
        $show->field('category', __('Category'));
        $show->field('amount', __('Amount'));
        $show->field('payment_method', __('Payment method'));
        $show->field('recipient', __('Recipient'));
        $show->field('description', __('Description'));
        $show->field('receipt', __('Receipt'));
        $show->field('date', __('Date'));
        $show->field('quantity', __('Quantity'));

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

        $form->number('garden_id', __('Garden id'));
        $form->number('user_id', __('User id'));
        $form->text('category', __('Category'));
        $form->text('amount', __('Amount'));
        $form->text('payment_method', __('Payment method'));
        $form->text('recipient', __('Recipient'));
        $form->text('description', __('Description'));
        $form->text('receipt', __('Receipt'));
        $form->date('date', __('Date'))->default(date('Y-m-d'));
        $form->text('quantity', __('Quantity'));

        return $form;
    }
}
