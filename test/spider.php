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
foreach($rs as $row){
    $row["grep"] = "/\"[\w]+\"/";
    $row["splitstr"] = ",";
    $spider->setParams($row);
    $spider->init();
    $rs = $spider->run();
    debugVar($rs);
    exit;
}