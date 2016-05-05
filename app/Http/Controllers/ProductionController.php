<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Model\Production;
use App\Http\Requests;
use App\Model\ProductionColor;
use App\Model\ProductionImage;
use App\Model\ProductionSize;
use App\Model\Series;
use App\Model\UserAddress;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('c');

        if(isset($category) && is_numeric($category) && $category != 0) {
            $productions = Production::where('category_id', $category)->get();
        } else {
            $productions = Production::all();
            $category = 0;
        }

        $series = Series::getAll();

        return view('production.index', [
            'productions' => $productions,
            'series' => $series,
            'category' => $category,
        ]);
    }

    public function redirect(Request $request, $alias)
    {
        $production = Production::where('alias', $alias)->first();
        if(isset($production)) {
            $productionColor = $production->color()->first();
            if(isset($productionColor)) {
                return redirect("production/{$alias}/{$productionColor->alias}");
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function show(Request $request, $alias, $colorAlias)
    {
        $production = Production::where('alias', $alias)->first();
        $productionColor = $production->color()->where('alias', $colorAlias)->first();
        $sizes = ProductionSize::get($production->id, $colorAlias);
        $images = ProductionImage::get($production->id, $colorAlias);
        $colors = ProductionColor::get($production->id);

//        echo \GuzzleHttp\json_encode($sizes);

        if (isset($production)
            && isset($productionColor)
            && isset($sizes)
            && isset($images)
            && isset($colors)
        ) {
            return view('production.show', [
                'production' => $production,
                'thisColor' => $productionColor,
                'sizes' => $sizes,
                'images' => $images,
                'colors' => $colors,
            ]);
        } else {
            abort(404);
        }
    }


    public function getQuantityBySize(Request $request, $sizeId)
    {
        if (!is_numeric($sizeId)) {
            return response()->json([
                'error' => 0,
            ]);
        }

        $productionSize = ProductionSize::find($sizeId);

        if (!empty($productionSize)) {
            return response()->json([
                'success' => 0,
                'quantity' => $productionSize->quantity,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }
}
