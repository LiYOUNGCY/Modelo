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
}
