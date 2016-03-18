<?php

namespace App\Http\Controllers;

use App\Production;
use App\Http\Requests;
use App\ProductionColor;
use App\ProductionSize;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        return view('production.index');
    }

    public function show($alias)
    {
        $production = Production::getProductionByAlias($alias);
        if (!empty($production)) {
            $productionColor = Production::getProductionColorByAlias($alias);
            $data = Production::getProduction($productionColor[0]->id);

            return view('production.show', [
                'production' => $production,
                'data' => $data,
            ]);
        } else {
            abort(404);
        }
    }

    public function redirect(Request $request, $alias)
    {
        $production = Production::getProductionByAlias($alias);
        if (!empty($production)) {
            $productionColor = Production::getProductionColorByAlias($alias);
            return redirect("buy/{$alias}/{$productionColor[0]->alias}");
        } else {
            abort(404);
        }
    }

    public function buy(Request $request, $alias, $colorAlias)
    {
        $production = Production::getProductionByAlias($alias);
        $productionColor = ProductionColor::where('alias', $colorAlias)->first();

        if (!empty($production) && !empty($productionColor)) {
            $size_id = $request->get('size');
            $size = ProductionSize::find($size_id);
            if (empty($size)) {
                $sizes = Production::getProductionSize($productionColor->id);
                return redirect("buy/{$alias}/{$productionColor->alias}?size={$sizes[0]->id}");
            } else {
                $colors = Production::getProductionColorByAlias($alias);
                $data = [];

                foreach ($colors as $color) {
                    $data[$color->alias] = Production::getProduction($color->id);
                }

                return view('production.buy', [
                    'production' => $production,
                    'colors' => $colors,
                    'data' => $data,
                    'colorAlias' => $colorAlias,
                    'colorPrice' => $productionColor->price,
                    'sizeQuantity' => $size->quantity,
                    'sizeId' => $size_id,
                ]);
            }
        } else {
            abort(404);
        }
    }

    public function getQuantityBySize(Request $request, $sizeId)
    {
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
