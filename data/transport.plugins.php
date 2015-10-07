<?php
/**
 * Created by PhpStorm.
 * User: andriyanov-dy
 * Date: 07.10.15
 * Time: 8:53
 */
function prettify($filename){
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}
$plugins = array();
$plugins[1]= $modx->newObject('modPlugin');
$plugins[1]->fromArray(array(
    'id' => 1,
    'name' => 'TurboCache',
    'description' => 'Турбокэш',
    'plugincode' => prettify($sources['source_assets'].'plugin.TurboCache.php'),
//    'static' => 1,
//    'static_file' => 'assets/components/turbo_cache/plugin.TurboCache.php',
),'',true,true);
$properties = include $sources['data'].'properties/properties.turboCache.php';
$plugins[1]->setProperties($properties);
$events = ['OnWebPagePrerender','OnDocFormSave','OnCacheUpdate'];
$pluginEvents = [];

$query = $modx->newQuery('modPluginEvent', array('event:IN'=>$events));
$pluginEvents = $modx->getCollection('modPluginEvent',$query);

//$plugins[1]->addMany($pluginEvents);
$pluginEvents = $plugins[1]->getMany('PluginEvents');
$plugins[1]->addMany($pluginEvents);
unset($properties);

return $plugins;