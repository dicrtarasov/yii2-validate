<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 07.04.20 14:49:30
 */

/** @noinspection PhpUnused */
declare(strict_types = 1);

error_reporting(- 1);
ini_set('display_errors', '1');

define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@dicr/tests', __DIR__);
Yii::setAlias('@dicr/validate', dirname(__DIR__) . '/src');

