<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2
 * Time: 23:40
 */

namespace GliderSky\framework\data;


class FileStore
{
    private $_aConfig = array();
    private $_oHandle = null;

    public function __construct($params=array())
    {
        if(empty($params)){
            $this->_aConfig = \Config::$Config["store"]["file"];
        }else{
            $this->_aConfig = $params;
        }
    }

    public function set($sKey,$sStr,$timeout=0,$mode="a+"){
        $this->_oHandle = fopen($this->_aConfig["dir"]."/".$sKey.".txt",$mode);
        if($this->_oHandle){
            fputs($this->_oHandle,$sStr."\n",2048);
        }
        fclose($this->_oHandle);
    }
}