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
for($i=1;$i<7;$i++){
    $contents = file_get_contents("http://nufm.dfcfw.com/EM_Finance2014NumericApplication/JS.aspx?cb=jQuery112409293433910496316_1540123130227&type=CT&token=4f1862fc3b5e77c150a2b985b12db0fd&sty=FCOIATC&js=(%7Bdata%3A%5B(x)%5D%2CrecordsFiltered%3A(tot)%7D)&cmd=R.MK0214%7CMK0212%7CMK0213%7CMK0202&flt=repeatoff&st=(ChangePercent)&sr=-1&p={$i}&ps=20&_=1540123130277");
    $aContent = explode('","',$contents);
    foreach($aContent as $row){
        $aResult = explode(",",$row);
        $code = $aResult[1];
        $name = $aResult[2];
        $rs2 = $module->query("select * from us_china_code where code='{$code}';");
        if(empty($rs2)){
            $module->query("insert into us_china_code(code,enable,ctime,mtime)values('{$code}',1,now(),now());");
        }else{
            $module->query("update us_china_code set enable = 1 where code='{$code}'");
        }
    }
}