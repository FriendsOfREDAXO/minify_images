<?php
	if (rex::isBackend()) {
		if (rex_addon::get('media_manager')->isAvailable()) {
			rex_media_manager::addEffect('rex_effect_optimize');
			rex_media_manager::addEffect('rex_effect_define_quality');
		}
	}
?>