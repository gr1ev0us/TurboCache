<?php
/**
 * Created by PhpStorm.
 * User: artexoid
 * Date: 30.08.15
 * Time: 20:04
 */

class TurboCache {

    /** @var Modx */
    private static $modx;

    /**
     * @return string
     */
    private static function getCachePath() {

        static $path = null;

        if (is_null($path)) {
            if (!is_null(self::$modx)) {
                $path = self::$modx->getCachePath() . 'turbo_cache/';
            } else {
                $path = dirname(dirname(dirname(__DIR__))) . '/core/cache/turbo_cache/';
            }
        }

        return $path;
    }

    /**
     * @param object $resource
     * @return string
     */
    private static function getCacheFile($resource = null) {

        $resourceUri = str_replace('/', '_', !is_null($resource) ? $resource->uri : self::$modx->resource->uri);
        $path = self::getCachePath() . $resourceUri . '.cache';

        return $path;
    }

    /**
     * @param Modx $modx
     * @return bool
     */
    public static function onWebPagePrerender(&$modx) {
        self::$modx = &$modx;

        if (file_exists(self::getCacheFile())) {
            return false;
        }

        if (!file_exists(self::getCachePath())) {
            mkdir(self::getCachePath(), 0777, true);
        }

        $headers = headers_list();
        $content = $modx->resource->_output;

        $cache = (object)[
            'headers' => $headers,
            'content' => $content,
            'date' => microtime(true)
        ];

        file_put_contents(self::getCacheFile(), serialize($cache));

        return true;
    }

    /**
     * @param Modx $modx
     * @param object $resource
     * @return bool
     */
    public static function onDocFormSave(&$modx, &$resource) {
        self::$modx = &$modx;

        if (!file_exists(self::getCacheFile($resource))) {
            return false;
        }

        return unlink(self::getCacheFile($resource));
    }

    /**
     * @param Modx $modx
     * @return bool
     */
    public static function onCacheUpdate(&$modx) {
        self::$modx = &$modx;

        foreach(glob(self::getCachePath() . '*.cache') as $file) {
            unlink($file);
        }

        return true;
    }

    /**
     * @param array $exclude
     * @return bool|object
     */
    public static function onRequest($exclude = []) {
        $request = !empty($_REQUEST['q']) ? $_REQUEST['q'] : 'index/';

        if (!empty($exclude) && preg_match('/^(' . implode('|', $exclude) . ').*/', $request)) {
            return false;
        }

        $resource = (object)[
            'uri' => $request
        ];

        if (file_exists(self::getCacheFile($resource))) {
            return (object)unserialize(file_get_contents(self::getCacheFile($resource)));
        }

        return false;
    }
}