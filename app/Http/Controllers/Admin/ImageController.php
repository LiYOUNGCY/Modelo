<?php

namespace App\Http\Controllers\Admin;

use App\Model\Image;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Http\Requests;

class ImageController extends AdminController
{
    public function index(Request $request)
    {
        $images = Image::getAll();

        return view('admin.image.index', [
            'images' => $images,
        ]);
    }

    public function show($id)
    {
        $image = Image::get($id);

        return view('admin.image.show', [
            'image' => $image,
        ]);
    }

    public function create()
    {
        return view('admin.image.create');
    }

    public function store(Request $request)
    {
        $name = $request->get('name');
        var_dump($name);
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $key => $imageFile) {
                if ($imageFile->isValid()) {
                    $image = new Image();
                    $image->storeImage(
                        $name[$key],
                        $imageFile,
                        $imageFile->extension()
                    );
                }
            }
        }

        return redirect("{$this->ADMIN}/image");
    }

    public function destroy($id)
    {
        if(Image::destroy($id)) {
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $image = Image::find($id);
        $name = $request->get('name');

        if (isset($image)) {
            if ($request->hasFile('image')) {
                $photo = $request->file('image');
                if ($photo->isValid()) {
                    $image->storeImage(
                        $name,
                        $photo,
                        $photo->getExtension()
                    );
                }
            } else {
                $image->name = $name;
                $image->save();
            }

            return redirect("{$this->ADMIN}/image");
        } else {
            abort(404);
        }
    }
}
