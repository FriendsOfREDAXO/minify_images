<?php
if (rex::isBackend() && rex_addon::get('media_manager')->isAvailable()) {
    rex_media_manager::addEffect('rex_effect_optimize');
}
