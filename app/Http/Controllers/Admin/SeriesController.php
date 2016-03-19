<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Series;
use Illuminate\Http\Request;
use App\Http\Requests;

class SeriesController extends AdminController
{
    public function index(Request $request)
    {
        $page = $request->get('page');
        $page = is_null($page) || !is_numeric($page) ? 1 : $page;
        $series = Series::getAll($page);

        return view('admin.series.index', [
            'series' => $series,
            'page' => Series::getAllPage(),
            'nowPage' => $page,
        ]);
    }

    public function create()
    {
        return view('admin.series.create');
    }

    public function store(Request $request)
    {
        $name = $request->get('name');
        $alias = $request->get('alias');

        $series = new Series();
        $series->name = $name;
        $series->alias = $alias;
        $series->save();

        return redirect("{$this->ADMIN}/series");
    }

    public function destroy($id)
    {
        $series = Series::find($id);

        if (isset($series)) {
            $series->delete();

            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }
}
