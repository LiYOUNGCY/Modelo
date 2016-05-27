<?php

namespace App\Http\Controllers\Admin;

use App\Model\GroupProduction;
use App\Model\Image;
use App\Model\Series;
use App\Model\SeriesGroup;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function create()
    {
        $series = Series::getAll();
        $images = Image::getAll();

        return view('admin.group.create', [
            'series' => $series,
            'images' => $images,
        ]);
    }


    public function store(Request $request)
    {
        $series_id = $request->get('series_id');
        $image_id = $request->get('image_id');

        $group = new SeriesGroup();
        $group->series_id = $series_id;
        $group->image_id = $image_id;
        $group->save();

        return response()->json([
            'success' => 0,
            'group_id' => $group->id,
        ]);
    }

    public function storeGroupProduction(Request $request)
    {
        $group_id = $request->get('group_id');
        $production_ids = $request->get('production_id');

        foreach ($production_ids as $production_id) {
            $groupProduction = new GroupProduction();
            $groupProduction->series_group_id = $group_id;
            $groupProduction->production_id = $production_id;
            $groupProduction->save();
        }

        return response()->json([
            'success' => 0,
        ]);
    }
}
