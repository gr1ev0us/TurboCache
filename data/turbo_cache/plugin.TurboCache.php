<?php
include_once(MODX_ASSETS_PATH . 'components/turbo_cache/cacher.php');

switch ($modx->event->name) {
    case 'OnWebPagePrerender':
        TurboCache::onWebPagePrerender($modx);
        break;
    case 'OnDocFormSave':
        TurboCache::onDocFormSave($modx, $resource);
        break;
    case 'OnCacheUpdate':
        TurboCache::onCacheUpdate($modx);
        break;
}