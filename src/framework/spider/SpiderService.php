<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 20:57
 */

namespace GliderSky\framework\spider;

use GliderSky\lib\ArrayUtil;
use GliderSky\lib\DateType;

class SpiderService
{
    private $_aParams = array();
    private $_aConfig = array();
    private $_oParseRules = null;

    public function __construct($sName)
    {
        $this->_aConfig = \Config::$Config["spider"][$sName];
        $this->_oParseRules = new ParseRules();
    }

    public function setParams($aParams){
        $this->_aParams = $aParams;
    }

    private function checkRunStart(){
        $time = date("H:i");
        if($this->_aConfig["endtime"] < $this->_aConfig["starttime"]){
            if($time >= $this->_aConfig["starttime"] or $time <= $this->_aConfig["endtime"]){
                return true;
            }else{
                return false;
            }
        }else{
            if($time <= $this->_aConfig["endtime"] and $time >= $this->_aConfig["starttime"]){
                return true;
            }else{
                return false;
            }
        }
    }

    public function run($sFormat=""){
        if($this->checkRunStart() == false){
            return false;
        }
        $url = $this->parseUrl();
        $rs = $this->fetchData(strtolower($url));
        $data = $this->_oParseRules->getData($this->_aConfig["parse_rule"],$rs);
        $rs = $this->_oParseRules->saveData($data,$this->_aConfig["save_rule"],$this->_aParams);
        if(empty($sFormat)){
            return $rs;
        }elseif($sFormat == "double_array_to_string"){
            return ArrayUtil::oneArrayToString($rs);
        }elseif($sFormat == "json"){
            return json_encode($rs);
        }
    }

    private function fetchData($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    private function parseUrl(){
        $url = DateType::replace($this->_aConfig["url"], $this->_aParams);
        return DateType::replaceDate($url);
    }
}