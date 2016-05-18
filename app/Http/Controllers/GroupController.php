<?php

namespace App\Http\Controllers;

use App\Model\GroupProduction;
use App\Model\Series;
use App\Model\SeriesGroup;
use Illuminate\Http\Request;
use Log;

use App\Http\Requests;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $series_id = $request->get('s');

        $series = Series::where('id', $series_id)->first();

        if(isset($series)) {
            $seriesGroup = SeriesGroup::where('series_id', $series_id)->get();

            $groupProduction = [];
            foreach ($seriesGroup as $value) {
                $groupProduction[$value->id] = GroupProduction::getProductionImage($value->id);
            }


            return view('theme.index', [
                'series' => $series,
                'seriesGroups' => $seriesGroup,
                'groupProductions' => $groupProduction,
            ]);
            echo \GuzzleHttp\json_encode($groupProduction);
        } else {
            Log::info('THEME NOT FOUND. '."series id: {$series_id}");
            abort('404');
        }
    }
}
