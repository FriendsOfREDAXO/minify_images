<?php
	class rex_effect_optimize extends rex_effect_abstract {
		private $addonName = 'minify_images';
		
		public function execute() {
			$this->media->asImage();
			
			$format = $this->media->getFormat();
			$filepath = rex_path::addonCache($this->addonName,'temp_'.microtime());
			
			rex_dir::create(dirname($filepath));
			
			switch ($format) {
				case 'jpeg':
					imagejpeg($this->media->getImage(), $filepath, rex_config::get('media_manager', 'jpg_quality', 80));
				break;
				case 'png':
					imagepng($this->media->getImage(), $filepath, rex_config::get('media_manager', 'jpg_quality', 80));
				break;
				case 'gif':
					imagegif($this->media->getImage(), $filepath);
				break;
			}
			
			//Start - optimize image
				if (rex_addon::get($this->addonName)->getConfig('optimization_tool') == 'ImageOptimizer') {
					try {
						$factory = new \ImageOptimizer\OptimizerFactory([
							'ignore_errors' => false,
						]);
						
						$optimizer = $factory->get();
						$optimizer->optimize($filepath);
					} catch (Exception $exception) {
						
					}
				} else if (rex_addon::get($this->addonName)->getConfig('optimization_tool') == 'Imagick') {
					try {
						$iMagick = new Imagick();
						$iMagick->readImage($filepath);
						$iMagick->optimizeImageLayers();
						
						switch ($format) {
							case 'jpeg':
								$iMagick->setImageCompression(Imagick::COMPRESSION_JPEG);
							break;
							case 'png':
								$iMagick->setImageCompression(Imagick::COMPRESSION_UNDEFINED);
							break;
							case 'gif':
								$iMagick->setImageCompression(Imagick::COMPRESSION_UNDEFINED);
							break;
						}
						
						$iMagick->setImageCompressionQuality(rex_config::get('media_manager', 'jpg_quality', 80));
						$iMagick->stripImage(); 
						
						$iMagick->writeImages($filepath, true);
					} catch (Exception $exception) {
						
					}
				} else if (rex_addon::get($this->addonName)->getConfig('optimization_tool') == 'Tinify') {
					$key = rex_addon::get($this->addonName)->getConfig('tinify_key');
					if (!$key) {
						return;
					}
					
					try {
						//Start - try to use tinify
							\Tinify\Tinify::setKey($key);
							\Tinify\validate();
							\Tinify\fromFile($filepath)->toFile($filepath);
						//End - try to use tinify
					} catch(\Tinify\Exception $e) {
						
					}
				}
			//End - optimize image
			
			$this->media->setImage(imagecreatefromstring(rex_file::get($filepath)));
			
			unlink($filepath);
		}
	}
?>