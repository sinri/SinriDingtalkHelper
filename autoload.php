<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/9/30
 * Time: 14:08
 *
 * @deprecated since 0.2
 */

use sinri\sinridingtalkhelper\ApiHelper\SinriDingtalkHelper;

require_once __DIR__ . '/ApiHelper/SinriDingtalkHelper.php';

spl_autoload_register(function ($class_name) {
    $file_path = SinriDingtalkHelper::getFilePathOfClassNameWithPSR0(
        $class_name,
        'sinri\sinridingtalkhelper',
        __DIR__,
        '.php'
    );
    if ($file_path) {
        require_once $file_path;
    }
});