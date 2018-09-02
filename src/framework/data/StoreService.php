<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/2
 * Time: 23:38
 */

namespace GliderSky\framework\data;


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
                break;
        }
    }

    public function save($sKey,$aData){
        return $this->_oObj->save($sKey,$aData);
    }
}