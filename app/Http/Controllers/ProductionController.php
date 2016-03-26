<?php

namespace App\Http\Controllers;

use App\Model\Production;
use App\Http\Requests;
use App\Model\ProductionColor;
use App\Model\ProductionSize;
use App\Model\User;
use App\Model\UserAddress;
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
            $size = Production::getProductionSize($productionColor->id);
            $size = $size[0];
            $colors = Production::getProductionColorByAlias($alias);
            $data = [];

            foreach ($colors as $color) {
                $data[$color->alias] = Production::getProduction($color->id);
            }

            $request->session()->set('prevUrl', $request->url());

            return view('production.buy', [
                'production' => $production,
                'colors' => $colors,
                'data' => $data,
                'colorAlias' => $colorAlias,
                'colorPrice' => $productionColor->price,
                'sizeQuantity' => $size->quantity,
                'sizeId' => $size->id,
                'address' => UserAddress::where('user_id', User::getUser()['id'])->first(),
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
