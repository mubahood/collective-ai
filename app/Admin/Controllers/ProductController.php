<?php

namespace App\Admin\Controllers;

use App\Models\Location;
use App\Models\Product;
use App\Models\Utils;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Products & Services';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        //disable filter
        $grid->disableFilter();

        //diable the column selector
        $grid->disableColumnSelector();
        
     
        $grid->quickSearch('name')->placeholder('Search by name');
        $grid->column('photo', __('Photo'))
            ->display(function ($avatar) {
                $img = url("storage/" . $avatar);
                return '<img class="img-fluid " style="border-radius: 10px;"  src="' . $img . '" >';
            })
            ->width(80)
            ->sortable();
        $grid->column('name', __('Product Name'));
        $grid->column('price', __('Price'));
        $grid->column('state', __('State'));
        $grid->column('category', __('Category'));
  
      
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
        $show = new Show(Product::findOrFail($id));

        $show->field('administrator_id', __('Administrator id'))->as(function ($id) {
            $a = Administrator::find($id);
            if ($a) {
                return  $a->name;
            }
        });
        $show->field('name', __('Name'));
        $show->field('type', __('Type'));
        $show->field('photo', __('Photo'))->image();
        $show->field('details', __('Details'));
        $show->field('price', __('Price'));
        $show->field('offer_type', __('Offer type'));
        $show->field('state', __('State'));
        $show->field('category', __('Category'));
     

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        if (
            (Auth::user()->isRole('staff')) ||
            (Auth::user()->isRole('admin'))
        ) {

            $ajax_url = url(
                '/api/ajax?'
                    . "search_by_1=name"
                    . "&search_by_2=id"
                    . "&model=User"
            );
            $form->select('administrator_id', "Product provider")
                ->options(function ($id) {
                    $a = Administrator::find($id);
                    if ($a) {
                        return [$a->id => "#" . $a->id . " - " . $a->name];
                    }
                })
                ->ajax($ajax_url)->rules('required');
        } else {
            $form->select('administrator_id', __('Product provider'))
                ->options(Administrator::where('id', Auth::user()->id)->get()->pluck('name', 'id'))->default(Auth::user()->id)->readOnly()->rules('required');
        }


        $form->radio('type', __('Item type'))->options([
            'Product' => 'Product',
            'Service' => 'Service',
        ])->rules('required');

        $form->text('name', __('Item name'))->rules('required');
        $form->image('photo', __('Photo'))->rules('required');

        $form->radio('state', __('Item State'))->options([
            'New' => 'New',
            'Used but like new' => 'Used but like new',
            'Used' => 'Used',
        ])->rules('required');

        $form->radio('offer_type', __('Offer type'))->options([
            'For sale' => 'For sale',
            'For hire' => 'For hire/Rent',
        ])->rules('required');

        $form->decimal('price', __('Price (in UGX)'))->rules('required');

        $form->text('subcounty_id', __('Location'))
            ->rules('required');


        $form->text('details', __('Details'))->rules('required');

        return $form;
    }
}
