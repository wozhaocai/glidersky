<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:00
 */
/**
 * 连涨超过2天
 */

require_once "glidersky.php";

$oStock = new \GliderSky\framework\arithmetic\StockService();
$oStock->calculate("urdgt","test\model\UsChinaPriceModel");

