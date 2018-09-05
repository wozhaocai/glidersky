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
$spider = new \GliderSky\framework\spider\SpiderService("US_CHINA");
$store = new \GliderSky\framework\data\StoreService("file");
foreach($rs as $row){
    $spider->setParams($row);
    $rs = $spider->run();
    if($rs){
        $store->save($row["code"].".".$rs["day"],json_encode($rs));
    }
}