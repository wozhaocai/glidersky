<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 23:10
 */

require_once "glidersky.php";

//$codeList = \GliderSky\lib\Memcacheds::get("codelist");
//if(!empty($result)){
    $module = new \GliderSky\framework\data\ModelService("test\model\UsChinaCodeModel");
    $codeList = $module->query("select distinct code from {table} where enable=1;");
    \GliderSky\lib\Memcacheds::set("codelist",$codeList,3600);
//}

//$codePriceLast = \GliderSky\lib\Memcacheds::get("codePriceLastlist");
//if(!empty($codePriceLast)){
    $stockmodule = new \GliderSky\framework\data\ModelService("test\model\UsChinaPriceModel");
    $codePriceLast = $stockmodule->query("select * from {table} where id in (select max(id) from (select * from {table} order by day desc) as a group by a.code);");
    $codePriceLast = \GliderSky\lib\ArrayUtil::setKeyArr($codePriceLast,"code");
    \GliderSky\lib\Memcacheds::set("codePriceLastlist",$codePriceLast,3600);
//}

$spider = new \GliderSky\framework\spider\SpiderService("US_CHINA");
$params =  [
    "file" => [
        "dir" => "/home/data/stock/show",
    ]
];
$store = new \GliderSky\framework\data\StoreService("file",$params);

foreach($codeList as $row){
    $spider->setParams($row);
    $rs = $spider->run();
    if($rs){
        $codePrice = \GliderSky\lib\Memcacheds::get("today_".$row["code"]);
        $str = array("{$row["code"]}-{$rs["cname"]}\n");
        if(!empty($codePrice)){
            if(!empty($rs["buy_sum"]) and $rs["buy_sum"]/$codePrice["buy_sum"] > 1.5){
                $str[] = "-------------"."与前一次量比大于2";
            }
        }
        if(!empty($codePriceLast[$row["code"]]["buy_sum"]) and $rs["buy_sum"]/$codePriceLast[$row["code"]]["buy_sum"] > 1.5){
            $str[] = "-------------"."与前一日量比大于2";
        }
        if(count($str) > 1){
            echo implode("\n",$str)."\n";
        }
        \GliderSky\lib\Memcacheds::set("today_".$row["code"],$rs,70);
        $today = date("Y-m-d");
        $store->save($row["code"].".".$today,implode("\n",$str)."\n");
    }
}



