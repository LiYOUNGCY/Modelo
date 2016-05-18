<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\AdminController;
use App\Model\Image;
use Illuminate\Http\Request;

use App\Http\Requests;

class ImageController extends AdminController
{
    public function all()
    {
        $images = Image::all();

        return response()->json([
            'success' => 0,
            'data' => $images,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('images')) {
            $images = $request->file('images');


            foreach ($images as $key => $imageFile) {
                if ($imageFile->isValid()) {
                    $fileName = $imageFile->getClientOriginalName();
                    $fileName = explode('.', $fileName);
                    $fileName = $fileName[0];

                    $image = Image::where('name', $fileName)->first();
                    if(! isset($image)) {
                        $image = new Image();
                    }

                    $image->storeImage(
                        $fileName,
                        $imageFile,
                        $imageFile->extension()
                    );
                }
            }
        }

        return response()->json([
            'success' => 0,
        ]);
    }
}
