<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/21
 * Time: 20:08
 */
require_once "glidersky.php";
$module = new \GliderSky\framework\data\ModelService("test\model\UsChinaCodeModel");
$rs = $module->query("update us_china_code set enable = 0");
for($i=1;$i<4;$i++){
    $contents = getContent("http://money.finance.sina.com.cn/q/api/jsonp_v2.php/IO.XSRV2.CallbackList['67Z2Li8QDcOFhql1']/US_ChinaStockService.getData?page={$i}&num=60&sort=&asc=0&market=&concept=0");
    $str = iconv("GBK","utf-8",$contents);
    $str = substr(str_replace("IO.XSRV2.CallbackList['67Z2Li8QDcOFhql1'](","",$str),0,-1);
    $aContent = explode('symbol:"',$str);
    sleep(1);
    foreach($aContent as $m=>$row){
        if($m == 0) continue;
        $aResult = explode('",name:"',$row);
        $aName = explode('",market:"',$aResult[1]);
        $code = $aResult[0];
        $name = $aName[0];
        $rs2 = $module->query("select * from us_china_code where code='{$code}';");
        if(empty($rs2)){
            $module->query("insert into us_china_code(code,enable,ctime,mtime)values('{$code}',1,now(),now());");
        }else{
            $module->query("update us_china_code set enable = 1 where code='{$code}'");
        }
    }
}

function getContent($url){
    $curl = curl_init();
//设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
//设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
//设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

//重要！
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)"); //模拟浏览器代理

//执行命令
    $data = curl_exec($curl);
//关闭URL请求
    curl_close($curl);
    return $data;
}