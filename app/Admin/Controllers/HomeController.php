<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PestAndDiseaseController;
use App\Models\Garden;
use App\Models\GardenActivity;
use App\Models\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\QuestionController;
use App\Models\Farmer;
use App\Models\GroundnutVariety;
use App\Models\Market;
use App\Models\PestsAndDiseaseReport;
use App\Models\PriceRecord;
use App\Models\Product;
use App\Models\ServiceProvider;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function questions(Content $content)
    {

        $u = Auth::user();
        $content
            ->title('Farmers Forum');
        $content->row(function (Row $row) {
            $row->column(12, function (Column $column) {
                $column->append(QuestionController::get_questions());
            });
        });
        return $content;
    }

    public function answers(Content $content, $id)
    {
        $content
            ->title('Answers');
        $content->row(function (Row $row) use ($id) {
            $row->column(12, function (Column $column) use ($id) {
                $column->append(QuestionController::question_answers($id));
            });
        });
        return $content;
    }

    public function pestsAndDiseases(Content $content)
    {

        $u = Auth::user();
        $content
            ->title('Ask the expert');
        $content->row(function (Row $row) {
            $row->column(12, function (Column $column) {
                $column->append(PestAndDiseaseController::index());
            });
        });
        return $content;
    }


    public function index(Content $content)
    {
        //return $content;
        $u = Auth::user();
        $content
            ->title('C.A.I.T - Dashboard')
            ->description('Hello ' . $u->name . "!");



        $u = Admin::user();


        $content->row(function (Row $row) {
            $row->column(3, function (Column $column) {
                $column->append(view('widgets.box-5', [
                    'is_dark' => false,
                    'title' => 'Registered Users',
                    'sub_title' => 'All Users',
                    'number' => number_format(User::count()),
                    'link' => admin_url('users')
                ]));
            });

            $row->column(3, function (Column $column) {
                $column->append(view('widgets.box-5', [
                    'is_dark' => false,
                    'title' => 'Markets',
                    'sub_title' => 'Markets',
                    'number' => number_format(Market::count()),
                    'link' => admin_url('markets')
                ]));
            });
            $row->column(3, function (Column $column) {
                $column->append(view('widgets.box-5', [
                    'is_dark' => false,
                    'title' => 'Missing prices',
                    'sub_title' => 'Missing prices',
                    'number' => number_format(PriceRecord::where('status', 'Pending')->count()),
                    'link' => admin_url('price-records')
                ]));
            });
            $row->column(3, function (Column $column) {
                $column->append(view('widgets.box-5', [
                    'is_dark' => false,
                    'title' => 'Submitted Prices',
                    'sub_title' => 'Submitted Prices',
                    'number' => number_format(PriceRecord::where('status', 'Submitted')->count()),
                    'link' => admin_url('price-records')
                ]));
            });
        });

        return $content;
        $content->row(function (Row $row) {
            $row->column(4, function (Column $column) {
                $pests = PestsAndDiseaseReport::where([])->orderBy('created_at', 'desc')->limit(5)->get();
                $column->append(view('widgets.pests-2', [
                    'data' => $pests,
                ]));
            });

            $row->column(4, function (Column $column) {
                $top_pests = Garden::selectRaw('count(*) as count, crop_id')
                    ->groupBy('crop_id')
                    ->orderBy('count', 'desc')
                    ->limit(5)
                    ->get();
                $counts = [];
                $lables = [];
                foreach ($top_pests as $key => $value) {
                    $district = $value->variety;
                    $name = '';
                    if ($district != null) {
                        $name = $district->name;
                    }
                    $counts[] = $value->count;
                    $lables[] = $name . " (" . $value->count . ")";
                }

                $column->append(view('widgets.by-categories', [
                    'counts' => $counts,
                    'lables' => $lables
                ]));
            });

            $row->column(4, function (Column $column) {
                $pests = PestsAndDiseaseReport::where([])->orderBy('created_at', 'desc')->limit(5)->get();

                //get pests count order by top district_id count
                $top_pests = PestsAndDiseaseReport::selectRaw('count(*) as count, district_id')
                    ->groupBy('district_id')
                    ->orderBy('count', 'desc')
                    ->limit(5)
                    ->get();
                $counts = [];
                $lables = [];
                foreach ($top_pests as $key => $value) {
                    $district = $value->district;
                    $counts[] = $value->count;
                    $lables[] = $district->name . " (" . $value->count . ")";
                }

                $column->append(view('widgets.pests', [
                    'data' => $pests,
                    'counts' => $counts,
                    'lables' => $lables
                ]));
            });
        });

        $content->row(function (Row $row) {
            $row->column(6, function (Column $column) {
                $column->append(view('widgets.groundnut-market', []));
            });
            $row->column(6, function (Column $column) {
                $column->append(view('widgets.products-services', []));
            });
        });

        return $content;
        $content->row(function (Row $row) {
            $row->column(12, function (Column $column) {
                $column->append(view('widgets.weather', []));
            });
        });


        return $content;
    }
}
