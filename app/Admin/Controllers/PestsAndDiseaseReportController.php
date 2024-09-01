<?php

namespace App\Admin\Controllers;

use App\Models\PestsAndDiseaseReport;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PestsAndDiseaseReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pests And Disease Reports';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PestsAndDiseaseReport());
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Sn'))->sortable();
        $grid->column('created_at', __('Date'))->sortable()
            ->display(function ($created_at) {
                return Utils::my_date($created_at);
            });
        $grid->column('pests_and_disease_id', __('Pests/Disease'))
            ->display(function ($pests_and_disease_id) {
                $pestsAndDisease = \App\Models\PestsAndDisease::find($pests_and_disease_id);
                if ($pestsAndDisease == null) {
                    return 'Unknown';
                }
                return $pestsAndDisease->category;
            })->sortable();
        $grid->column('garden_id', __('Garden'))
            ->display(function ($garden_id) {
                $garden = \App\Models\Garden::find($garden_id);
                if ($garden == null) {
                    return 'Unknown';
                }
                return $garden->name;
            })->sortable(); 
        $grid->column('crop_id', __('Crop'))
            ->display(function ($crop_id) {
                $crop = \App\Models\Crop::find($crop_id);
                if ($crop == null) {
                    return 'Unknown';
                }
                return $crop->name;
            })->sortable(); 
        $grid->column('user_id', __('User'))
            ->display(function ($user_id) {
                $user = \App\Models\User::find($user_id);
                if ($user == null) {
                    return 'Unknown';
                }
                return $user->name;
            })->sortable(); 
        $grid->column('district_id', __('District id'));
        $grid->column('subcounty_id', __('Subcounty id'));
        $grid->column('parish_id', __('Parish id'));
        $grid->column('description', __('Description'));
        $grid->column('photo', __('Photo'));
        $grid->column('video', __('Video'));
        $grid->column('expert_answer', __('Expert answer'));
        $grid->column('expert_answer_photo', __('Expert answer photo'));
        $grid->column('expert_answer_video', __('Expert answer video'));
        $grid->column('expert_answer_audio', __('Expert answer audio'));
        $grid->column('expert_answer_description', __('Expert answer description'));
        $grid->column('gps_lati', __('Gps lati'));
        $grid->column('gps_longi', __('Gps longi'));

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
        $show = new Show(PestsAndDiseaseReport::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('pests_and_disease_id', __('Pests and disease id'));
        $show->field('garden_id', __('Garden id'));
        $show->field('crop_id', __('Crop id'));
        $show->field('user_id', __('User id'));
        $show->field('district_id', __('District id'));
        $show->field('subcounty_id', __('Subcounty id'));
        $show->field('parish_id', __('Parish id'));
        $show->field('description', __('Description'));
        $show->field('photo', __('Photo'));
        $show->field('video', __('Video'));
        $show->field('expert_answer', __('Expert answer'));
        $show->field('expert_answer_photo', __('Expert answer photo'));
        $show->field('expert_answer_video', __('Expert answer video'));
        $show->field('expert_answer_audio', __('Expert answer audio'));
        $show->field('expert_answer_description', __('Expert answer description'));
        $show->field('gps_lati', __('Gps lati'));
        $show->field('gps_longi', __('Gps longi'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PestsAndDiseaseReport());

        $form->number('pests_and_disease_id', __('Pests and disease id'));
        $form->number('garden_id', __('Garden id'));
        $form->number('crop_id', __('Crop id'));
        $form->number('user_id', __('User id'));
        $form->number('district_id', __('District id'));
        $form->number('subcounty_id', __('Subcounty id'));
        $form->number('parish_id', __('Parish id'));
        $form->textarea('description', __('Description'));
        $form->textarea('photo', __('Photo'));
        $form->textarea('video', __('Video'));
        $form->textarea('expert_answer', __('Expert answer'));
        $form->textarea('expert_answer_photo', __('Expert answer photo'));
        $form->textarea('expert_answer_video', __('Expert answer video'));
        $form->textarea('expert_answer_audio', __('Expert answer audio'));
        $form->textarea('expert_answer_description', __('Expert answer description'));
        $form->textarea('gps_lati', __('Gps lati'));
        $form->textarea('gps_longi', __('Gps longi'));

        return $form;
    }
}
