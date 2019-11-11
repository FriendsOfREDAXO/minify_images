<?php

use ImageOptimizer\OptimizerFactory;
use Tinify\Tinify;
use function Tinify\fromFile;
use function Tinify\validate;

class rex_effect_optimize extends rex_effect_abstract
{
    private $addonName = 'minify_images';

    public function execute()
    {
        $this->media->asImage();

        $format = $this->media->getFormat();
        $filepath = rex_path::addonCache($this->addonName, 'temp_' . microtime());

        rex_dir::create(dirname($filepath));

        switch ($format) {
            case 'jpeg':
                imagejpeg($this->media->getImage(), $filepath, rex_config::get('media_manager', 'jpg_quality', 80));
                break;
            case 'png':
                imagepng($this->media->getImage(), $filepath, rex_config::get('media_manager', 'png_compression', 5));
                break;
            case 'gif':
                imagegif($this->media->getImage(), $filepath);
                break;
        }

        switch (rex_addon::get($this->addonName)->getConfig('optimization_tool')) {

            case 'ImageOptimizer':
                try {
                    $factory = new OptimizerFactory([
                        'ignore_errors' => false,
                    ]);
                    $optimizer = $factory->get();
                    $optimizer->optimize($filepath);
                } catch (Exception $e) {
                    rex_logger::logException($e);
                }
                break;

            case 'Imagick':
                if (!extension_loaded('imagick')) {
                    rex_logger::logError(E_WARNING, 'Minify: ImageMagick selected but not available', __FILE__, __LINE__);
                } else {
                    try {
                        $iMagick = new Imagick();
                        $iMagick->readImage($filepath);
                        $iMagick->optimizeImageLayers();

                        switch ($format) {
                            case 'jpeg':
                                $iMagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                                break;
                            default:
                                $iMagick->setImageCompression(Imagick::COMPRESSION_UNDEFINED);
                                break;
                        }

                        $iMagick->setImageCompressionQuality(rex_config::get('media_manager', 'jpg_quality', 80));
                        $iMagick->stripImage();
                        $iMagick->writeImages($filepath, true);
                    } catch (Exception $e) {
                        rex_logger::logException($e);
                    }
                }
                break;

            case 'Tinify':
                $key = rex_addon::get($this->addonName)->getConfig('tinify_key');
                if (!$key) {
                    rex_logger::logError(E_WARNING, 'Minify: Tinify selected but no API key provided', __FILE__, __LINE__);
                } else {
                    try {
                        Tinify::setKey($key);
                        validate();
                        fromFile($filepath)->toFile($filepath);
                    } catch (\Tinify\Exception $e) {
                        rex_logger::logException($e);
                    }
                }
                break;
        }

        $this->media->setImage(imagecreatefromstring(rex_file::get($filepath)));

        unlink($filepath);
    }

    public function getName()
    {
        return rex_i18n::msg('minify_images_effect_optimize');
    }
}
