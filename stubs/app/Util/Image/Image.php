<?php

namespace App\Util\Image;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Str;

/**
 * Helper Class for Image Uploader and Image Manipulation
 * Using Intervention Image
 * 
 * Aleks --
 */
class Image
{
    /**
     * Data for image
     *
     * @var request data
     */
    protected $data;

    /**
     * Driver for Image
     * @var GD / Imagick --> default GD
     */
    protected $driver;

    /**
     * Intervention Image
     * 
     * @var Intervention Image Object
     */
    protected $image;

    /**
     * Storage For Image
     *
     * @var Illuminate\Support\Facades\Storage
     */
    protected $storage;

    /**
     * Image destination directory
     * 
     *  @var string path
     */
    protected $imageFolder = 'images';

    /**
     * Image Name
     * 
     * @var random string
     */

    protected $name;

    /**
     * Image quantity
     * 
     * @var integer image quantity
     */
    protected $quantity = 80;

    /**
     * Create New Image Instance
     * 
     * @param string image destination directory
     * @param request data
     * @param $driver GD / Imagick --> default GD
     */
    function __construct($folder, $data = null, $driver = null)
    {
        $this->driver      = $driver; //ex:imagick
        $this->storage     = Storage::disk('public_upload');
        $this->imageFolder = $this->imageFolder . '/' . $folder;

        if ($data) {
            $this->data  = $data;

            $this->build();
        }
    }

    /**
     * Change Storage for storing image, 
     * Default is public_upload disk
     * folder 'public\uploads\image'
     *
     * @param Illuminate\Support\Facades\Storage
     */
    public function setStorage(FilesystemAdapter $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Get generated image name
     * 
     * @return random string image name
     */
    public function name()
    {
        return $this->name;
    }

    public function crop(array $size)
    {
        $this->image->crop(
            (int)$this->data->width,
            (int)$this->data->height,
            (int)$this->data->x,
            (int)$this->data->y
        );

        $this->image->backup();
        $this->image->resize($size[0], $size[1]);

        $this->save();

        $this->image->reset();

        return $this;
    }

    public function medium($size)
    {
        $this->image->fit($size[0], $size[1]);

        $this->save('medium/');

        $this->image->reset();

        return $this;
    }

    public function small($size)
    {
        $this->image->fit($size[0], $size[1]);

        $this->save('small/');

        $this->image->reset();

        return $this;
    }

    public function widen($width)
    {
        $this->image->widen($width);

        $this->save();

        $this->image->reset();

        return $this;
    }

    public function heighten($height)
    {
        $this->image->heighten($height);

        $this->save();

        $this->image->reset();

        return $this;
    }

    public function thumbnail($size)
    {
        $this->image->fit($size[0], $size[1]);

        $this->save('thumbnail/');

        $this->image->reset();

        return $this;
    }

    /**
     * Resize image with specified width
     * 
     * @param int width size
     */
    public function resize($width)
    {
        $this->image->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $this->save();

        $this->image->reset();

        return $this;
    }

    /**
     * Get Intervention Image Instance
     */
    public function image()
    {
        return $this->image;
    }

    /**
     * Delete Image
     * 
     * @param string image name or array image name
     */
    public function delete($image)
    {
        $directories   = $this->storage->allDirectories($this->imageFolder);
        $directories[] = $this->imageFolder;

        foreach ($directories as $dir) {
            $imageFile = $dir . '/' . $image;

            if ($this->storage->exists($imageFile)) {
                $this->storage->delete($imageFile);
            }
        }
    }

    public function save($folder = '')
    {
        $this->image->save($this->directory($folder) . $this->name, $this->quantity);
    }

    /**
     * Save image only without any preprocessing
     * support for SVG image
     **/
    public function store(Request $data)
    {
        $this->data = $data;
        $this->generateImageName();

        $this->data->image->storeAs($this->imageFolder, $this->name, 'public_upload');
    }

    protected function build()
    {
        $image = $this->data->image->getRealPath();

        if ($this->driver) {
            InterventionImage::configure(['driver' => $this->driver]);
        }

        $this->image  = InterventionImage::make($image);

        $this->generateImageName();

        $this->image->backup();
    }

    protected function generateImageName()
    {
        $this->name = Str::random(30) . '.' . $this->data->image->getClientOriginalExtension();
    }

    /**
     * Check image directory, if not exists, create directory
     * 
     * @param string directory
     */
    protected function directory($folder)
    {
        $dir =  $this->imageFolder . '/' . $folder;

        if (!$this->storage->exists($dir)) {
            $this->storage->makeDirectory($dir, 0777, true);
        }

        return $this->storage->path($dir);
    }
}
