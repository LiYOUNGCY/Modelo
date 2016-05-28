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

    public function index()
    {
        $productions = Production::all();

        return view('admin.production.index', [
            'productions' => $productions,
        ]);
    }


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

    public function store(Request $request)
    {
        $name = $request->get('name');
        $series_id = $request->get('series_id');
        $cover_id = $request->get('cover_id');
        $series_image = $request->get('series_image');
        $size_info_id = $request->get('size_info_id');
        $fabric_info_id = $request->get('fabric_info_id');
        $category = $request->get('category');

        $production = new Production();
        $production->name = $name;
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

    public function storeColor(Request $request, $productionId)
    {
        $colorName = $request->get('colorName');
        $colorImage = $request->get('colorImage');
        $colorPrice = $request->get('colorPrice');

        $productionColor = ProductionColor::create([
            'production_id' => $productionId,
            'image_id' => $colorImage,
            'name' => $colorName,
            'price' => $colorPrice,
        ]);

        //store image
        $images = $request->get('image');
        if(isset($images)) {
            foreach ($images as $image) {
                ProductionImage::create([
                    'production_color_id' => $productionColor->id,
                    'image_id' => $image,
                ]);
            }
        }

        //store size
        $sizes = $request->get('size');
        $quantities = $request->get('quantity');

        if(isset($sizes)) {
            foreach ($sizes as $key => $size) {
                ProductionSize::create([
                    'production_color_id' => $productionColor->id,
                    'name' => $size,
                    'quantity' => $quantities[$key],
                ]);
            }
        }

        return response()->json([
            'success' => 0,
        ]);
    }

    public function edit($productionId)
    {
        $production = Production::find($productionId);
        $productionColors = ProductionColor::where('production_id', $production->id)->get();

        $productionSize = [];
        $productionImage = [];
        $productionCategory = ProductionCategory::where('production_id', $production->id)->get();

        foreach ($productionColors as $productionColor) {
            $productionSize[$productionColor->id] = ProductionSize::where('production_color_id', $productionColor->id)->get();

            $productionImage[$productionColor->id] = ProductionImage::where('production_color_id', $productionColor->id)->get();
        }

        $images = Image::all();
        $series = Series::all();
        $categories = Category::all();

        if(isset($production)) {
            return view('admin.production.edit', [
                'production' => $production,
                'productionCategory' => $productionCategory,
                'productionColors' => $productionColors,
                'productionImages' =>$productionImage,
                'productionSizes' => $productionSize,
                'categories' => $categories,
                'images' => $images,
                'series' => $series,
            ]);
        }
        else {
            abort(404);
        }
    }

    public function updateProduction(Request $request, $productionId)
    {
        $production = Production::find($productionId);

        if(isset($production)) {
            $name = $request->get('name');
            $series_id = $request->get('series_id');
            $cover_id = $request->get('cover_id');
            $series_image = $request->get('series_image');
            $size_info_id = $request->get('size_info_id');
            $fabric_info_id = $request->get('fabric_info_id');
            $production->name = $name;
            $production->series_id = $series_id;
            $production->cover_id = $cover_id;
            $production->series_image = $series_image;
            $production->size_info_id = $size_info_id;
            $production->fabric_info_id = $fabric_info_id;
            $production->save();

            //clear all category
            ProductionCategory::where('production_id', $production->id)->delete();

            $category = $request->get('category');
            //save category
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
            ]);
        } else {
            abort(404);
        }
    }

    public function updateColor(Request $request, $colorId)
    {
        $productionColor = ProductionColor::find($colorId);

        if(isset($productionColor)) {
            $colorName = $request->get('colorName');
            $colorImage = $request->get('colorImage');
            $colorPrice = $request->get('colorPrice');

            $productionColor->name = $colorName;
            $productionColor->image_id = $colorImage;
            $productionColor->price = $colorPrice;
            $productionColor->save();

            //update image
            $imageIds = $request->get('imageId');
            $images = $request->get('image');

            if(isset($imageIds)) {
                foreach ($imageIds as $key => $imageId) {
                    $image = ProductionImage::find($imageId);

                    if (!isset($image)) {
                        $image = new ProductionImage();
                        $image->production_color_id = $productionColor->id;
                    }

                    $image->image_id = $images[$key];
                    $image->save();
                }
            }
            
            //update size
            $sizeIds = $request->get('sizeId');
            $sizes = $request->get('size');
            $amount = $request->get('amount');
            $quantity = $request->get('quantity');
            $i = 0;

            if(isset($sizeIds)) {
                foreach ($sizeIds as $key => $sizeId) {
                    $size = ProductionSize::find($sizeId);

                    if (!isset($size)) {
                        $size = new ProductionSize();
                        $size->production_color_id = $productionColor->id;
                        $size->name = $sizes[$key];
                        $size->quantity = $quantity[$i++];
                    } else {
                        $size->name = $sizes[$key];
                        $size->quantity += $amount[$key];
                    }
                    $size->save();
                }
            }

            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    public function destroyColor(Request $request, $colorId)
    {
        $productionColor = ProductionColor::find($colorId);

        if(isset($productionColor)) {
            $productionColor->delete();
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    public function destroyImage(Request $request, $imageId)
    {
        $productionImage = ProductionImage::find($imageId);

        if(isset($productionImage)) {
            $productionImage->delete();
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    public function destroySize(Request $request, $colorId)
    {
        $productionSize = ProductionSize::find($colorId);

        if(isset($productionSize)) {
            $productionSize->delete();
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    public function destroyProduction(Request $request, $Id)
    {
        $production = Production::find($Id);

        if(isset($production)) {
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
}
