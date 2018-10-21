<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2
 * Time: 23:38
 */

namespace GliderSky\framework\data;

use GliderSky\lib\Memcached;

class StoreService
{
    private $_oObj = null;

    public function __construct($sType)
    {
        switch($sType){
            case "file":
                $this->_oObj = new FileStore();
                break;
            default:
                //$this->_oObj = Memcached::get;
                break;
        }
    }

    public function set($sKey,$aData,$time=3600){
        return $this->_oObj->set($sKey,$aData,$time);
    }

    public function get($sKey){
        return $this->_oObj->get($sKey);
    }

}