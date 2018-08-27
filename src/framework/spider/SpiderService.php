<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 20:57
 */

namespace GliderSky\framework\arithmetic;

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
        $this->fetchData();
    }

    private function fetchData(){
        $rs = file_get_contents($this->_sUrl);
        debugVar($rs);
        exit;
    }

    private function parseUrl(){
        $this->_sUrl = DateType::replace($this->_sUrl, $this->_aParams);
        $this->_sUrl = DateType::replaceDate($this->_sUrl);
    }
}