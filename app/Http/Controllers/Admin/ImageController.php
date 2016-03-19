<?php

namespace App\Http\Controllers\Admin;

use App\Model\Image;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use PHPImageWorkshop\ImageWorkshop;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageController extends AdminController
{
    public function index(Request $request)
    {
        $page = $request->get('page');
        $page = is_null($page) ? 1 : $page;
        $images = Image::getAll($page);

        return view('admin.image.index', [
            'images' => $images,
            'page' => Image::getAllPage(),
            'nowPage' => $page,
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
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $key => $image) {
                if ($image->isValid()) {
                    $this->storeImage(new Image(), $name[$key], $image);
                }
            }
        }

        return redirect("{$this->ADMIN}/image");
    }

    public function destroy($id)
    {
        $image = Image::find($id);

        if (isset($image)) {
            $this->destroyImage($image->path);
            $image->delete();
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
                    $this->storeImage($image, $name, $photo);
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

    private function storeImage(Image $image, $name, UploadedFile $file)
    {
        $path = $this->renameAndMove($file);
        $layer = ImageWorkshop::initFromPath($path['absolutePath']);

        $image->name = $name;

        if (isset($image->path)) {
            //destroy the image
            $this->destroyImage($image->path);
        }
        $image->path = $path['relativePath'];

        $image->width = $layer->getWidth();
        $image->height = $layer->getHeight();
        $image->save();
    }

    private function renameAndMove(UploadedFile $file)
    {
        $newName = str_random() . '.' . $file->getClientOriginalExtension();
        $file->move(base_path() . "/public/images", $newName);
        return [
            'absolutePath' => base_path() . "/public/images/" . $newName,
            'relativePath' => "images/{$newName}",
        ];
    }

    private function destroyImage($imagePath)
    {
        $fileName = '';
        //parse the imagePath
        if (is_array($imagePath)) {
            $fileName = end($imagePath);
        } else if (is_string($imagePath)) {
            $fileName = explode('/', $imagePath);
            $fileName = end($fileName);
        }

        //delete from disk
        Storage::disk('public')->delete($fileName);
    }
}
