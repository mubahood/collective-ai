<?php

namespace App\Admin\Controllers;

use App\Models\Market;
use App\Models\PriceRecord;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PriceRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Price Records';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PriceRecord());
        //filters
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->between('due_date', __('Due Date'))->date();
            $markets = Market::all()->pluck('name', 'id');
            $filter->equal('market_id', __('Market'))->select($markets);
            $commodities = \App\Models\Commodity::all()->pluck('name', 'id');
            $districts = \App\Models\District::all()->pluck('name', 'id');
            $filter->equal('district_id', __('District'))->select($districts);
            $filter->equal('commodity_id', __('Commodity'))->select($commodities);
        });

        $grid->export(function ($export) {
            $export->filename('price-records-' . date('Y-m-d'));

            $export->column('status', function ($value, $original) {
                return $value;
            });
            //price direction
            $export->column('price_direction', function ($value, $original) {
                return $value;
            });

            $export->originalValue([
                'wholesale_price',
                'retail_price',
                'price_direction',
                'status',
            ]);


            return $export;
        });

        $grid->disableCreateButton();
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('updated_at', __('Updated'))
            ->display(function ($updated_at) {
                return Utils::my_date($updated_at);
            })->sortable()->hide();
        $grid->column('due_date', __('Date'))->sortable();

        $grid->column('market_id', __('Market'))
            ->display(function ($market_id) {
                if ($this->market == null) {
                    return 'N/A';
                }
                return $this->market->name;
            })->sortable();

        $grid->column('commodity_id', __('Commodity'))->sortable()
            ->display(function ($commodity_id) {
                if ($this->commodity == null) {
                    return 'N/A';
                }
                return $this->commodity->name;
            });

        $grid->column('wholesale_price', __('Wholesale Price (UGX)'))
            ->display(function ($wholesale_price) {
                return number_format($wholesale_price);
            })->sortable()->editable();
        $grid->column('retail_price', __('Retail Price (UGX)'))
            ->display(function ($retail_price) {
                return number_format($retail_price);
            })->sortable()->editable();
        $grid->column('measurement_unit', __('Measurement Unit'));
        $grid->column('price_direction', __('Price Direction'))
            ->display(function ($price_direction) {
                $bgColor = 'bg-dark';
                if ($price_direction == 'Stable') {
                    $bgColor = 'bg-dark';
                } elseif ($price_direction == 'Rising') {
                    $bgColor = 'bg-success';
                } elseif ($price_direction == 'Falling') {
                    $bgColor = 'bg-danger';
                }
                return "<span class='badge $bgColor'>$price_direction</span>";
            })->sortable()
            ->filter([
                'Stable' => 'Stable',
                'Rising' => 'Rising',
                'Falling' => 'Falling',
            ]);
        $grid->column('comment', __('Comment'))->hide();
        $grid->column('status', __('Status'))
            ->display(function ($status) {
                $bgColor = 'bg-dark';
                if ($status == 'Pending') {
                    $bgColor = 'bg-danger';
                } elseif ($status == 'Submitted') {
                    $bgColor = 'bg-success';
                }
                return "<span class='badge $bgColor'>$status</span>";
            })->sortable()
            ->filter([
                'Pending' => 'Pending',
                'Submitted' => 'Submitted',
            ]);

        $grid->column('market_id', __('Market'))
            ->display(function ($parish_id) {
                if ($this->market == null) {
                    return 'N/A';
                }
                return $this->market->name;
            })->sortable();

        $grid->column('parish_id', __('Parish'))
            ->display(function ($parish_id) {
                if ($this->parish == null) {
                    return 'N/A';
                }
                return $this->parish->name_text;
            })->sortable();
        $grid->column('subcounty_id', __('Subcounty'))
            ->display(function ($subcounty_id) {
                if ($this->subcounty == null) {
                    return 'N/A';
                }
                return $this->subcounty->name_text;
            })->sortable()->hide();
        $grid->column('district_id', __('District'))
            ->display(function ($district_id) {
                if ($this->district == null) {
                    return 'N/A';
                }
                return $this->district->name;
            })->sortable()->hide();
        $grid->column('gps', __('Gps'))->sortable()->hide();

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
        $show = new Show(PriceRecord::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('data_collection_generator_id', __('Data collection generator id'));
        $show->field('due_date', __('Due date'));
        $show->field('commodity_id', __('Commodity id'));
        $show->field('market_id', __('Market id'));
        $show->field('parish_id', __('Parish id'));
        $show->field('subcounty_id', __('Subcounty id'));
        $show->field('district_id', __('District id'));
        $show->field('gps', __('Gps'));
        $show->field('wholesale_price', __('Wholesale price'));
        $show->field('retail_price', __('Retail price'));
        $show->field('measurement_unit', __('Measurement unit'));
        $show->field('price_direction', __('Price direction'));
        $show->field('comment', __('Comment'));
        $show->field('status', __('Status'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PriceRecord());
        $form->number('data_collection_generator_id', __('Data collection generator id'));
        $form->date('due_date', __('Due date'))->default(date('Y-m-d'));
        $form->number('commodity_id', __('Commodity id'));
        $form->number('market_id', __('Market id'));
        $form->number('parish_id', __('Parish id'));
        $form->number('subcounty_id', __('Subcounty id'));
        $form->number('district_id', __('District id'));
        $form->textarea('gps', __('Gps'));
        $form->number('wholesale_price', __('Wholesale price'));
        $form->number('retail_price', __('Retail price'));
        $form->textarea('measurement_unit', __('Measurement unit'));
        $form->text('price_direction', __('Price direction'))->default('Stable');
        $form->textarea('comment', __('Comment'));
        $form->text('status', __('Status'))->default('Pending');

        return $form;
    }
}
