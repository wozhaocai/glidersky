<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 23:10
 */

require_once "glidersky.php";

$codeList = \GliderSky\lib\Memcacheds::get("codelist");
if (empty($codeList)) {
    $module = new \GliderSky\framework\data\ModelService("test\model\UsChinaCodeModel");
    $codeList = $module->query("select distinct code from {table} where enable=1;");
    \GliderSky\lib\Memcacheds::set("codelist", $codeList, 3600);
}

$spider = new \GliderSky\framework\spider\SpiderService("US_CHINA");
$params = [
    "dir" => "/home/data/stock/show",
];
$store = new \GliderSky\framework\data\StoreService("file", $params);
$aCodePrice = array();
$aCodeAllInfo = array();

foreach ($codeList as $row) {
    $spider->setParams($row);
    $rs = $spider->run('', false);
    if ($rs) {
        $sStr = "|股票名称:".$rs["cname"]."&nbsp;&nbsp;涨幅:".$rs["up_rate"]."%";
        $aCodePrice[$rs["code"].$sStr] = $rs["up_rate"];
    }
}

$aNowCodePrice = $aCodePrice;

arsort($aCodePrice);
asort($aNowCodePrice);

$today = date("Ymd");
$store->set("stock_desc_" . $today, implode("\n", array_keys($aCodePrice)) . "\n",3600,"w");
$store->set("stock_asc_" . $today, implode("\n", array_keys($aNowCodePrice)) . "\n",3600,"w");




