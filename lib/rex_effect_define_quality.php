<?php
	class rex_effect_define_quality extends rex_effect_abstract {
		public function execute() {
			$this->params['quality'] = (int) $this->params['quality'];
			if ($this->params['quality'] < 0) {
			  return;
			}
			
			$filepath = rex_path::addonCache('minify_images','temp_'.microtime());
			
			$format = $this->media->getFormat();
			switch ($format) {
				case 'jpeg':
					imagejpeg($this->media->getImage(), $filepath, $this->params['quality']);
				break;
				case 'png':
					imagepng($this->media->getImage(), $filepath, $this->params['quality']);
				break;
				case 'gif':
					imagegif($this->media->getImage(), $filepath);
				break;
			}
			
			$this->media->setImage(imagecreatefromstring(rex_file::get($filepath)));
			
			unlink($filepath);
		}
		
		public function getParams() {
			return [
				[
					'label' => rex_i18n::msg('minify_images_effect_define_quality_quality'),
					'name' => 'quality',
					'type' => 'int',
					'default' => '',
				],
			];
		}
	}
?>