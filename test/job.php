<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:00
 */
//php job.php -btest\model\UsChinaPriceModel -aurdgt -n2 中概连涨超过2天
//php job.php -btest\model\UsChinaPriceModel -asraug -n5 中概涨幅超过正负1个点，且量比小于1.2
//php job.php -btest\model\UsChinaPriceModel -asraul -n5 中概涨幅在正负1个点浮动，且量比小于1.2

require_once "glidersky.php";

$sHelp =<<<_HELP
此脚本进行sql转换，拆分表的字段
php job.php -b<business_id> -a<action> [-n<num>] [-d<YYYYmmdd>] [-m<YYYYmm>]

options: 
8  b : 必选，business_id
  a : 必选，action
  n : 可选，阈值
  d : 可选，日期
  m : 可选, 月份
              
_HELP;


$aOption = checkOpt($sHelp,'t::b::s::a::d::n::m::','a,b');
foreach($aOption as $sKey=>$sVal){
    $_POST[$sKey] = $sVal;
}

$oStock = new \GliderSky\framework\arithmetic\StockService();
$oStock->calculate($aOption["a"],$aOption["b"],$aOption["n"]);

function usage_help($sHelp) {
    echo str_replace("{script}", FILENAME, $sHelp);
    exit(0);
}

function checkOpt($sHelp, $sOption, $sMustOptionStr = '') {
    $aOption = getopt($sOption);
    if (!empty($sMustOptionStr)) {
        $aMustOption = explode(",", $sMustOptionStr);
        if (count($aMustOption) > 0) {
            foreach ($aMustOption as $sMustOption) {
                if (empty($aOption[$sMustOption])) {
                    usage_help($sHelp);
                }
            }
            return $aOption;
        } else {
            usage_help($sHelp);
        }
    } else {
        return $aOption;
    }
}

