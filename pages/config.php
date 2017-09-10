<?php
	$content = '';
	
	if (rex_post('config-submit', 'boolean')) {
		$this->setConfig(rex_post('config', [
			['tinify_active', 'bool'],
			['tinify_key', 'string'],
		]));

		$content .= rex_view::info($this->i18n('config_saved'));
	}

	$content .= '<div class="rex-form">';
	$content .= '  <form action="'.rex_url::currentBackendPage().'" method="post">';
	$content .= '    <fieldset>';
	
	$formElements = [];
	
	//Start - tinify_active
		$n = [];
		$n['label'] = '<label for="minify-config-tinify_active">'.$this->i18n('config_tinify_active').'</label>';
		$n['field'] = '<input type="checkbox" id="minify-config-tinify_active" name="config[tinify_active]" value="1" '.($this->getConfig('tinify_active') ? ' checked="checked"' : '').'>';
		$formElements[] = $n;
	//End - tinify_active
	
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