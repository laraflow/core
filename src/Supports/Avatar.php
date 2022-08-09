<?php

namespace Laraflow\Core\Supports;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Laravolt\Avatar\Facade as AvatarFacade;

class Avatar
{

    const IMAGE_JPG = 'jpg';

    const COLOR_WHITE = '#FFFFFF';

    public $filename = '';

    public $extension = self::IMAGE_JPG;

    /**
     * @var \Intervention\Image\Image|null $image
     */
    private $image;

    /**
     * @var array
     */
    public $config = [];

    /**
     * Avatar constructor.
     */
    public function __construct()
    {
        $this->config = Config::get('laravolt.avatar', []);

        $this->setImage($this->default());
    }

    /**
     * create a avatar image from text
     *
     * @param string $name
     * @param string $extension
     * @return string|null
     *
     * @throws Exception
     */
    public static function fromText(string $name, string $extension = self::IMAGE_JPG): ?string
    {
        $selfClass = new self();

        return ($selfClass->text($name)->save($extension))
            ? $selfClass->getTargetFilePath($extension)
            : null;
    }

    /**
     * create a avatar image from input
     *
     * @param string $key
     * @param string $extension
     * @return string|null
     * @throws Exception
     */
    public static function fromInput(string $key, string $extension = self::IMAGE_JPG): ?string
    {
        $selfClass = new self();

        return ($selfClass->input($key)->save($extension))
            ? $selfClass->getTargetFilePath($extension)
            : null;
    }

    /**
     * @param string $location
     * @param string $extension
     * @return string|null
     * @throws Exception
     */
    public static function fromFile(string $location, string $extension = self::IMAGE_JPG): ?string
    {
        $selfClass = new self();

        return ($selfClass->file($location)->save($extension))
            ? $selfClass->getTargetFilePath($extension)
            : null;
    }

    /**
     * @param \Intervention\Image\Image|null $image
     */
    public function setImage(\Intervention\Image\Image $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?\Intervention\Image\Image
    {
        return $this->image;
    }

    /**
     * Return temp location path
     *
     * @param string|null $temp_path
     * @return string
     */
    public function getTempDirectory(string $temp_path = null): string
    {
        $tmpPath = $temp_path ?? config('laravolt.avatar.temp_path');

        if (!is_dir($tmpPath))
            mkdir($tmpPath, '0777', true);

        return $tmpPath;
    }

    /**
     * @param null $extension
     * @return string
     */
    public function getTargetFilePath($extension = null): string
    {
        $filepath = rtrim($this->getTempDirectory()) . DIRECTORY_SEPARATOR . $this->filename;

        return ($extension != null)
            ? "{$filepath}.{$extension}"
            : "{$filepath}";

    }

    /**
     * @return \Intervention\Image\Image
     */
    public function default(): \Intervention\Image\Image
    {
        return Image::canvas($this->config['width'], $this->config['height'], self::COLOR_WHITE);
    }

    /**
     * @param string $text
     * @return self
     * @throws \Exception
     */
    private function text(string $text): self
    {
        try {
            $this->filename();
            $this->setImage(AvatarFacade::create($text)
                ->setDimension($this->config['width'], $this->config['height'])
                ->getImageObject());
        } catch (\Exception $exception) {
            Log::error("Avatar from text exception : " . $exception->getMessage());
            $this->setImage($this->default());
        }
        return $this;
    }

    /**
     * Return Image Object created from file location
     *
     * @param string $location
     * @return self
     * @throws \Exception
     */
    private function file(string $location): self
    {
        try {
            $this->filename($location);
            $this->setImage(Image::make($location));
        } catch (\Exception $exception) {
            Log::error("Avatar from filesystem exception : " . $exception->getMessage());
            $this->setImage($this->default());
        }
        return $this;
    }

    /**
     * Return Image Object created from request class
     *
     * @param string $key
     * @return self
     * @throws \Exception
     */
    private function input(string $key): self
    {
        try {
            $file = request()->file($key);
            $this->filename($file->getClientOriginalName());
            $this->setImage(Image::make($file));
        } catch (\Exception $exception) {
            Log::error("Avatar from request input exception : " . $exception->getMessage());
            $this->setImage($this->default());
        }
        return $this;
    }

    /**
     * @param string|null $filename
     * @return void
     */
    private function filename(string $filename = null)
    {
        if ($filename != null) {
            $fileInfo = pathinfo($filename);
        }

        $this->filename = $fileInfo['filename'] ?? Str::random(32);
        $this->extension = ($fileInfo['extension'] ?? self::IMAGE_JPG);
    }

    /**
     * @param string $extension
     * @return bool
     */
    public function save($extension = self::IMAGE_JPG): bool
    {
        $img = $this->getImage()
            ->resize($this->config['width'], $this->config['height'])
            ->save($this->getTargetFilePath($extension), 100, $extension);
        return (bool)($img instanceof \Intervention\Image\Image);
    }
}
