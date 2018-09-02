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

    public function run($sFormat=""){
        $this->parseUrl();
        $rs = $this->fetchData();
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

    private function fetchData(){
        return file_get_contents($this->_aConfig["url"]);
    }

    private function parseUrl(){
        $this->_aConfig["url"] = DateType::replace($this->_aConfig["url"], $this->_aParams);
        $this->_aConfig["url"] = DateType::replaceDate($this->_aConfig["url"]);
    }
}