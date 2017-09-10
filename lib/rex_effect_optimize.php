<?php
	class rex_effect_optimize extends rex_effect_abstract {
		public function execute() {
			$this->media->asImage();
			
			$format = $this->media->getFormat();
			$filepath = rex_path::addonCache('minify_images','temp_'.microtime());
			
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
				try {
					$factory = new \ImageOptimizer\OptimizerFactory([
						'ignore_errors' => false,
					]);
					
					$optimizer = $factory->get();
					$optimizer->optimize($filepath);
				} catch(Exception $exception) {
					if (rex_addon::get('minify_images')->getConfig('tinify_active')) {
						$key = rex_addon::get('minify_images')->getConfig('tinify_key');
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
				}
			//End - optimize image
			
			$this->media->setImage(imagecreatefromstring(rex_file::get($filepath)));
			
			unlink($filepath);
		}
	}
?>