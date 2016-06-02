<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPImageWorkshop\ImageWorkshop;
use Log;

class Image extends Model
{
    protected $table = 'image';

    protected $fillable = [
        'name',
        'path',
        'height',
        'width',
        'visible',
    ];

    protected static $limit = 20;

    public static function getAll()
    {
        $data = DB::table('image')
            ->where('image.visible', 1)
            ->select('*')
            ->get();

        return $data;
    }
    

    public static function get($id)
    {
        $data = DB::table('image')
            ->where('image.id', '=', $id)
            ->select('*')
            ->first();

        return $data;
    }

    public function storeImage($name, &$file, $suffix, $visible = true)
    {
        if (is_string($file)) {
            $this->_storeImage($name, $file, $suffix, $visible);
        } else if ($file instanceof UploadedFile) {
            $this->_storeImage(
                $name,
                file_get_contents($file->path()),
                $suffix,
                $visible
            );
        }
    }

    private function _storeImage($name, $file_content, $suffix, $visible = true)
    {
        $fileName = str_random(32) . ".{$suffix}";
        Storage::put($fileName, $file_content);

        //destory the image from path;
        if(! empty($this->path)) {
            $oldFileName = explode('/', $this->path);
            $oldFileName = end($oldFileName);
            Storage::delete($oldFileName);
        }

        $storagePath = Storage::getDriver()->getAdapter()->getPathPrefix();
        $absolutePath = $storagePath . $fileName;
        $layer = ImageWorkshop::initFromPath($absolutePath);
        
        //write the data to database
        $this->name = $name;
        $this->path = "images/{$fileName}";
        $this->width = $layer->getWidth();
        $this->height = $layer->getHeight();
//        $this->visible = $visible;
        $this->save();

        Image::where('id', $this->id)->update([
            'visible' => $visible,
        ]);

//        Image::create([
//            'name' => $name,
//            'path' => "images/{$fileName}",
//            'width' => $layer->getWidth(),
//            'height' => $layer->getHeight(),
//            'visible' => $visible,
//        ]);
    }


    public static function destroy($id)
    {
        $image = Image::find($id);

        if (isset($image)) {
            try {
                Image::destroyImage($image->path);
            } catch (\Exception $e) {
                Log::warning("[WARNING] {$e->getMessage()}");
            }

            $image->delete();
            return true;
        } else {
            return false;
        }
    }


    private static function destroyImage($imagePath)
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
