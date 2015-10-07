<?php
/**
 * Created by PhpStorm.
 * User: andriyanov-dy
 * Date: 07.10.15
 * Time: 9:25
 */
class PackageResolver{
    private $index;
    private $search ='$tstart= microtime(true);';
    private $replace = '$tstart= microtime(true);

//TurboCache
include_once(__DIR__ . \'/assets/components/turbo_cache/cacher.php\');
$result = TurboCache::onRequest([\'search\', \'sitemap.xml\']);
if ($result) {
    foreach ($result->headers as $header) {
        header($header);
    }

    echo $result->content;
    exit();
}';

    public function __construct() {
        $this->index = MODX_BASE_PATH . 'index.php';
    }


    public function onInstall(){
        $index = file_get_contents($this->index);
        if (empty($index)) {
            return false;
        }
        $index = str_replace($this->search, $this->replace, $index);
        if (!file_put_contents($this->index, $index)) {
            return false;
        }
        return true;
    }
    public function onUninstall(){
        $index = file_get_contents($this->index);
        $index = str_replace($this->replace, $this->search, $index);
        if (!file_put_contents($this->index, $index)) {
            return false;
        }
        return true;
    }
}
if ($object->xpdo) {
    $resolver = new PackageResolver();
    switch ($options[xPDOTransport::PACKAGE_ACTION]){
        case xPDOTransport::ACTION_INSTALL:
            return $resolver->onInstall();
        case xPDOTransport::ACTION_UNINSTALL:
            return $resolver->onUninstall();
    }
}
return true;