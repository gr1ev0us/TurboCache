<?php
/**
 * Created by PhpStorm.
 * User: andriyanov-dy
 * Date: 07.10.15
 * Time: 9:33
 */
$output = '';
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $output = '<h2>Установщик Турбокэша</h2>
<p>Благодарим за установку Турбокэша!</p><br />';
        break;
    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}
return $output;