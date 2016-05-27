<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Category;
use App\Model\Image;
use App\Model\Production;
use App\Model\ProductionCategory;
use App\Model\ProductionColor;
use App\Model\ProductionImage;
use App\Model\ProductionSize;
use App\Model\Series;
use Illuminate\Http\Request;
use App\Http\Requests;

class ProductionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productions = Production::all();

        return view('admin.production.index', [
            'productions' => $productions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $images = Image::all();
        $series = Series::all();
        $categories = Category::all();

        return view('admin.production.create', [
            'categories' => $categories,
            'images' => $images,
            'series' => $series,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $alias = $request->get('alias');
        $series_id = $request->get('series_id');
        $cover_id = $request->get('cover_id');
        $series_image = $request->get('series_image');
        $size_info_id = $request->get('size_info_id');
        $fabric_info_id = $request->get('fabric_info_id');
        $category = $request->get('category');

        $production = new Production();
        $production->name = $name;
        $production->alias = $alias;
        $production->series_id = $series_id;
        $production->cover_id = $cover_id;
        $production->series_image = $series_image;
        $production->size_info_id = $size_info_id;
        $production->fabric_info_id = $fabric_info_id;
        $production->save();

        if (isset($category) && is_array($category)) {

            foreach ($category as $value) {
                $productionCategory = new ProductionCategory();
                $productionCategory->production_id = $production->id;
                $productionCategory->category_id = $value;
                $productionCategory->save();
            }
        }

        return response()->json([
            'success' => 0,
            'production_id' => $production->id,
        ]);
    }

    public function storeColor(Request $request, $id)
    {
        $production = Production::find($id);

        if (isset($production)) {
            $name = $request->get('name');
            $price = $request->get('price');
            $alias = $request->get('alias');
            $image_id = $request->get('image_id');

            $productionColor = new ProductionColor();
            $productionColor->production_id = $id;
            $productionColor->name = $name;
            $productionColor->price = $price;
            $productionColor->alias = $alias;
            $productionColor->image_id = $image_id;
            $productionColor->save();

            return response()->json([
                'success' => 0,
                'color_id' => $productionColor->id,
            ]);
        }

        return response()->json([
            'error' => 0,
        ]);
    }

    public function storeSize(Request $request, $id, $cid)
    {
        //check the production exist?
        $production = Production::find($id);
        $productionColor = ProductionColor::find($cid);

        if (isset($production) && isset($productionColor)) {
            $sizes = $request->get('size');
            $quantityes = $request->get('quantity');
            $set = [];

            //check size is only one
            foreach ($sizes as $size) {
                if (empty($set[$size])) {
                    $set[$size] = true;
                } else {
                    return response()->json([
                        'error' => 0,
                        'message' => '尺码的值不能重复',
                    ]);
                }
            }

            //clear all
            ProductionSize::where('production_color_id', $cid)->delete();

            foreach ($sizes as $i => $size) {

                $productionSize = new ProductionSize();
                $productionSize->production_color_id = $cid;
                $productionSize->name = $size;
                $productionSize->quantity = $quantityes[$i];
                $productionSize->save();
            }

            return response()->json([
                'success' => 0,
            ]);
        }

        return response()->json([
            'error' => 0,
        ]);
    }

    public function storeImage(Request $request, $id, $cid)
    {
        //check the production exist?
        $production = Production::find($id);
        $productionColor = ProductionColor::find($cid);

        if (isset($production) && isset($productionColor)) {
            $images_id = $request->get('images_id');
            $primary = $request->get('primary');

            //clear all
            ProductionImage::where('production_color_id', $cid)->delete();

            foreach ($images_id as $i => $image_id) {
                $productionImage = new ProductionImage();
                $productionImage->production_color_id = $cid;
                $productionImage->image_id = $image_id;
                $productionImage->primary = $primary[$i];
                $productionImage->save();
            }

            return response()->json([
                'success' => 0,
            ]);
        }

        return response()->json([
            'error' => 0,
        ]);
    }

    /**
     * @param $alias
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($alias)
    {
        $production = Production::getProductionByAlias($alias);
        $colors = Production::getProductionColorByAlias($alias);
        $data = [];

        foreach ($colors as $color) {
            $data[$color->alias] = Production::getProduction($color->id);
        }

//        return response()->json([
////            'production' => $production,
////            'colors' => $colors,
////            'data' => $data,
//        ]);

        return view('admin.production.show', [
            'production' => $production,
            'colors' => $colors,
            'data' => $data,
        ]);
    }

    public function edit($alias)
    {
        $production = Production::getProductionByAlias($alias);
        $colors = Production::getProductionColorByAlias($alias);

        $data = [];

        foreach ($colors as $color) {
            $data[$color->alias] = Production::getProduction($color->id);
        }

        $images = Image::all();
        $series = Series::all();

        return view('admin.production.edit', [
            'production' => $production,
            'colors' => $colors,
            'data' => $data,
            'images' => $images,
            'series' => $series,
        ]);
    }

    public function updateProduction(Request $request, $id)
    {
        $production = Production::find($id);

        if (!empty($production)) {
            $name = $request->get('name');
            $alias = $request->get('alias');
            $cover_id = $request->get('cover_id');
            $series_id = $request->get('series_id');

            $production->name = $name;
            $production->alias = $alias;
            $production->cover_id = $cover_id;
            $production->series_id = $series_id;
            $production->save();

            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
                'message' => 'Object Not Found.',
            ]);
        }
    }

    public function updateProductionColor(Request $request, $id, $color_id)
    {
        $production = Production::find($id);
        if (isset($production)) {
            $productionColor = ProductionColor::findOrNew($color_id);
            $productionColor->production_id = $id;
            $productionColor->name = $request->get('color_name');
            $productionColor->alias = $request->get('color_alias');
            $productionColor->price = $request->get('color_price');
            $productionColor->save();

            //size
            $sizes = $request->get('size');
            if (isset($sizes) and is_array($sizes)) {
                foreach ($sizes as $size) {
                    $productionSize = ProductionSize::findOrNew($size['id']);
                    $productionSize->name = $size['size_name'];
                    $productionSize->production_color_id = $productionColor->id;
                    $productionSize->quantity = $size['size_quantity'];
                    $productionSize->save();
                }
            }

            //image
            $images = $request->get('image');
            if (isset($images) and is_array($images)) {
                //delete all images from this production
                ProductionImage::where('production_color_id', $productionColor->id)->delete();
                foreach ($images as $image) {
                    $productionImage = new ProductionImage();
                    $productionImage->production_color_id = $productionColor->id;
                    $productionImage->image_id = $image['image_id'];
                    $productionImage->primary = $image['image_type'];
                    $productionImage->save();
                }
            }


            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
                'message' => 'Production Not Found.',
            ]);
        }
    }


    public function destroyProduction($alias)
    {
        $production = Production::where('alias', $alias)->first();

        if (isset($production)) {
            $production->delete();
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    public function destroyColor($alias)
    {
        $color = ProductionColor::where('alias', $alias)->first();

        if (isset($color)) {
            $color->delete();
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    public function destroySize($id)
    {
        $size = ProductionSize::find($id);

        if (isset($size)) {
            $size->delete();
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    public function destroyImage($id)
    {
        if ($id == 0) {
            return response()->json([
                'success' => 0,
            ]);
        }

        $image = ProductionImage::find($id);
        if (isset($image)) {
            $image->delete();
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
                'message' => 'Production Image Not Found.'
            ]);
        }
    }
}
