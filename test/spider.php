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
//$store = new \GliderSky\framework\data\StoreService("file");
$stockmodule = new \GliderSky\framework\data\ModelService("test\model\MystockModel");
$mystock = $stockmodule->query("select * from {table} where id in (select max(id) from (select * from {table} where ctype='uschina' and isdel=0 order by day desc) as a group by a.code);");
$newMyStock = array();
$queuemodule = new \GliderSky\framework\data\ModelService("test\model\StockqueueModel");
foreach($mystock as $sKey=>$sVal){
    $newMyStock[$sVal["code"]] = $sVal;
}
foreach($rs as $row){
    $spider->setParams($row);
    $rs = $spider->run();
    if($rs){
        if(!empty($newMyStock[$row["code"]])){
            if($rs["up_rate"] < 0 and abs($rs["up_rate"]) > $newMyStock[$row["code"]]["sellval"]){
                send($row["code"],'seller');
            }elseif($rs["up_rate"] > 0 and $rs["up_rate"] > $newMyStock[$row["code"]]["buyval"]){
                send($row["code"],'buyer');
            }
        }
        //$store->save($row["code"].".".$rs["day"],json_encode($rs));
    }
}

function send($code,$type){
    global $queuemodule;
    $currentday = date("Y-m-d");
    $queue = $queuemodule->query("select * from {table} where code='{$code}' and day='{$currentday}' and type='{$type}'");
    if(empty($queue)){
        $queuemodule->query("insert into {table}(day,code,type,cnt) values('{$currentday}','{$code}','{$type}',1)");
    }else{
        if($queue[0]["cnt"] < 3){
            $queuemodule->query("update {table} set cnt=cnt+1 where code='{$code}' and day='{$currentday}' and type='{$type}'");
            $message = new \GliderSky\framework\message\MessageService("sell");
            $message->sendAlert($code,$type);
        }
        print_r("exceed 3");
    }
}



