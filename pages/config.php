<?php
	$content = '';
	
	if (rex_post('config-submit', 'boolean')) {
		$this->setConfig(rex_post('config', [
			['optimization_tool', 'string'],
			['tinify_key', 'string'],
		]));

		$content .= rex_view::info($this->i18n('config_saved'));
	}

	$content .= '<div class="rex-form">';
	$content .= '  <form action="'.rex_url::currentBackendPage().'" method="post">';
	$content .= '    <fieldset>';
	
	$formElements = [];
	
	//Start - optimization_tool
		$n = [];
		$n['label'] = '<label for="minify-config-optimization_tool">'.$this->i18n('config_optimization_tool').'</label>';
		$select = '';
		$select .= '<select id="minify-config-optimization_tool" name="config[optimization_tool]">';
		$select .= '  <option value="none">---</option>';
		$select .= '  <option value="ImageOptimizer" '.(($this->getConfig('optimization_tool') == 'ImageOptimizer') ? 'selected="selected"' : '').'>ImageOptimizer (pngquant / optipng / pngcrush / pngout / advpng / jpegtran / jpegoptim / gifsicle)</option>';
		$select .= '  <option value="Tinify" '.(($this->getConfig('optimization_tool') == 'Tinify') ? 'selected="selected"' : '').'>Tinify (tinyJPEG / tinyPNG)</option>';
		$select .= '  <option value="Imagick" '.(($this->getConfig('optimization_tool') == 'Imagick') ? 'selected="selected"' : '').'>Imagemagick</option>';
		$select .= '</select>';
		
		$n['field'] = $select;
		$formElements[] = $n;
	//End - optimization_tool
	
	//Start - tinify_key
		$n = [];
		$n['label'] = '<label for="minify-config-tinify_key">'.$this->i18n('config_tinify_key').'</label>';
		$n['field'] = '<input type="text" id="minify-config-tinify_key" name="config[tinify_key]" value="'.$this->getConfig('tinify_key').'"/>';
		$formElements[] = $n;
	//End - tinify_key
	
	$fragment = new rex_fragment();
	$fragment->setVar('elements', $formElements, false);
	$content .= $fragment->parse('core/form/form.php');
	
	$content .= '    </fieldset>';
	
	$content .= '    <fieldset class="rex-form-action">';
	
	$formElements = [];
	
	$n = [];
	$n['field'] = '<input type="submit" name="config-submit" value="'.$this->i18n('config_action_save').'" '.rex::getAccesskey($this->i18n('config_action_save'), 'save').'>';
	$formElements[] = $n;
	
	$fragment = new rex_fragment();
	$fragment->setVar('elements', $formElements, false);
	$content .= $fragment->parse('core/form/submit.php');
	
	$content .= '    </fieldset>';
	$content .= '  </form>';
	$content .= '</div>';
	
	$fragment = new rex_fragment();
	$fragment->setVar('class', 'edit');
	$fragment->setVar('title', $this->i18n('config'));
	$fragment->setVar('body', $content, false);
	echo $fragment->parse('core/page/section.php');
?>