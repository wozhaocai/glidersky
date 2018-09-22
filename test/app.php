<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/22
 * Time: 20:03
 */

require_once "glidersky.php";

use \GliderSky\framework\data\ModelService;
use \GliderSky\framework\spider\SpiderService;
use \GliderSky\framework\data\StoreService;

$module = new ModelService("test\model\UsChinaPriceModel");
$rs = $module->query("select distinct code from {table};");
$spider = new SpiderService("US_CHINA");
$store = new StoreService("file");
foreach($rs as $row){
    $spider->setParams($row);
    $rs = $spider->run();
    if($rs){
        $store->save($row["code"].".".$rs["day"],json_encode($rs));
    }
}