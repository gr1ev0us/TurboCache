<?php
/**
 * Created by PhpStorm.
 * User: andriyanov-dy
 * Date: 07.10.15
 * Time: 8:53
 */
$plugins = array();

$plugins[1]= $modx->newObject('modPlugin');
$plugins[1]->fromArray(array(
    'id' => 1,
    'name' => 'TurboCache',
    'description' => 'Турбокэш',
    'plugincode' => file_get_contents($sources['source_assets'].'plugin.TurboCache.php'),
//    'static' => 1,
//    'static_file' => 'assets/components/turbo_cache/plugin.TurboCache.php',
),'',true,true);
$properties = include $sources['data'].'properties/properties.turboCache.php';
$plugins[1]->setProperties($properties);
unset($properties);

return $plugins;