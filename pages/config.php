<?php
    /** @var rex_addon $this */

    $csrfToken = rex_csrf_token::factory('minify_images');

    if (rex_post('config-submit', 'boolean')) {
        if (!$csrfToken->isValid()) {

            echo rex_view::error(rex_i18n::msg('csrf_token_invalid'));
        }
        else {

            $this->setConfig(rex_post('config', [
                ['optimization_tool', 'string'],
                ['tinify_key', 'string'],
            ]));
            echo rex_view::success($this->i18n('config_saved'));
        }
    }


    $content = '<fieldset>';

    $formElements = [];

	// optimization_tool
    $sel_optimization_tool = new rex_select();
    $sel_optimization_tool->setid('minify-config-optimization_tool');
    $sel_optimization_tool->setName('config[optimization_tool]');
    $sel_optimization_tool->setSize(1);
    $sel_optimization_tool->setAttribute('class', 'form-control selectpicker');
    $sel_optimization_tool->setSelected($this->getConfig('optimization_tool'));
    $sel_optimization_tool->addOption('', 'none');
    $sel_optimization_tool->addOption('ImageOptimizer (optipng / pngquant / jpegoptim / svgo / …)', 'ImageOptimizer');
    $sel_optimization_tool->addOption('Tinify (tinyJPEG / tinyPNG)', 'Tinify');
    $sel_optimization_tool->addOption('ImageMagick', 'Imagick');

    $n = [];
    $n['label'] = '<label for="minify-config-optimization_tool">' . $this->i18n('config_optimization_tool') . '</label>';
    $n['field'] = $sel_optimization_tool->get();
    $formElements[] = $n;

    // tinify_key
    $n = [];
    $n['label'] = '<label for="minify-config-tinify_key">'.$this->i18n('config_tinify_key').'</label>';
    $n['field'] = '<input class="form-control" type="text" id="minify-config-tinify_key" name="config[tinify_key]" value="'.$this->getConfig('tinify_key').'"/>';
    $n['note'] = $this->i18n('minify_images_config_tinify_key_note');
    $formElements[] = $n;

    $fragment = new rex_fragment();
    $fragment->setVar('elements', $formElements, false);
    $content .= $fragment->parse('core/form/container.php');


    $formElements = [];
    $n = [];
    $n['field'] = '<button class="btn btn-save rex-form-aligned" type="submit" name="config-submit" value="1">' . $this->i18n('config_save') . '</button>';
    $formElements[] = $n;

    $fragment = new rex_fragment();
    $fragment->setVar('flush', true);
    $fragment->setVar('elements', $formElements, false);
    $buttons = $fragment->parse('core/form/submit.php');


	$fragment = new rex_fragment();
	$fragment->setVar('class', 'edit');
	$fragment->setVar('title', $this->i18n('config'));
    $fragment->setVar('body', $content, false);
    $fragment->setVar('buttons', $buttons, false);
    $content = $fragment->parse('core/page/section.php');

    echo '
        <form action="' . rex_url::currentBackendPage() . '" method="post">
            ' . $csrfToken->getHiddenField() . '
            ' . $content . '
        </form>';
?>
