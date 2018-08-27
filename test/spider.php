<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 23:10
 */

require_once "glidersky.php";

$module = new \GliderSky\framework\data\ModelService("test\model\UsChinaPriceModel");
$rs = $module->query("select distinct code from {table};");
debugVar($rs);
$spider = new \GliderSky\framework\arithmetic\SpiderService("US_CHINA");
foreach($rs as $row){
    $spider->setParams($row);
    $spider->init();
    $spider->run();
}