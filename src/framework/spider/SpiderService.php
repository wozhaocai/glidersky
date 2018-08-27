<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 20:57
 */

namespace GliderSky\framework\spider;

use GliderSky\lib\DateType;

class SpiderService
{
    private $_aParams = array();
    private $_sUrl = "";
    private $_aConfig = array();

    public function __construct($sName)
    {
        $this->_aConfig = \Config::$Config["spider"][$sName];
        $this->_sUrl = $this->_aConfig["url"];
    }

    public function init(){
        $this->_sUrl = $this->_aConfig["url"];
    }

    public function setParams($aParams){
        $this->_aParams = $aParams;
    }

    public function run(){
        $this->parseUrl();
        $rs = $this->fetchData();
        preg_match_all($this->_aParams["grep"], $rs, $matches);
        if(!empty($matches)){
            debugVar($matches);
        }
        exit;
    }

    private function fetchData(){
        return file_get_contents($this->_sUrl);
    }

    private function parseUrl(){
        $this->_sUrl = DateType::replace($this->_sUrl, $this->_aParams);
        $this->_sUrl = DateType::replaceDate($this->_sUrl);
    }
}