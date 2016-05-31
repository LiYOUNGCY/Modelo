<?php
/**
 * Created by PhpStorm.
 * User: rache
 * Date: 2016/5/31
 * Time: 11:13
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\Production;
use App\Model\ProductionColor;
use App\Model\ProductionImage;


class ImageController extends Controller
{
    public function index()
    {
        $productions = Production::all();

        return view('image.share', [
            'productions' => $productions,
        ]);
    }

    public function show($id)
    {
        $production = Production::find($id);
        $productionColor = ProductionColor::where('production_id', $production->id)->first();
        $images = ProductionImage::get($production->id, $productionColor->id);

        if (isset($production)) {
            return view('image.image', [
                'images' => $images,
            ]);
        }
    }
}