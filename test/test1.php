<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:00
 */
/**
 * 涨幅在正负1个点浮动，且量比小于1.2
 */

require_once "glidersky.php";

use test\model\UsChinaPriceModel;

$oModel = new UsChinaPriceModel();
$rs = $oModel->query("select distinct code from us_china_price;");
$all = array();
foreach($rs as $sCode){
    $sum = 1;
    $temp = array();
    $rs1 = $oModel->query("select day,now_price,up_rate,buy_sum from us_china_price where code='{$sCode['code']}' order by day desc limit 10");
    $temp["option"] = array_reverse($rs1);
    foreach($temp["option"] as $key=>$val){
        if($sum != 0){
            $temp["option"][$key]["sum_rate"] = $val["buy_sum"]/$sum;
        }else{
            $temp["option"][$key]["sum_rate"] = 1;
        }
        $sum = $val["buy_sum"];
    }
    $sql = "select ";
    $sql .= "max(now_price) as max_now_price,min(now_price) as min_now_price,";
    $sql .= "max(up_rate) as max_up_rate,min(up_rate) as min_up_rate,";
    $sql .= "max(buy_sum) as max_buy_sum,min(buy_sum) as min_by_sum ";
    $sql .= "from us_china_price where code='{$sCode['code']}' order by day desc limit 10";
    $temp["sum"] = $oModel->query($sql);
    $all[$sCode['code']] = $temp;
}
foreach($all as $sCode=>$aData){
    $aCulcData = array_reverse($aData["option"]);
    $num = 0;
    $iPrice = $aCulcData[0]["now_price"];
    foreach($aCulcData as $i => $row){
        if($row["sum_rate"] < 1.2 and abs($row["up_rate"]) > 0.01){
            $num++;
        }else{
            break;
        }
    }
    if($num > 5){
        echo "\n-------------------{$sCode}------------------------------\n";
        foreach($aCulcData as $i => $row){
            foreach($row as $key=>$val){
                echo $key.":".$val."\t";
            }
            echo "\n";
        }
        //debugVar($aCulcData);
    }
}

function debugVar($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}
