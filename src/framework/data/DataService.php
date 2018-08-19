<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 16:48
 */

namespace GliderSky\framework\data;

use GliderSky\lib\MysqlPdo;

class DataService
{
    private $_oDb = null;
    public function __construct($obj)
    {
        $aConfig = \Config::$Config["database"][$obj->connect];
        if($aConfig["type"] == "mysql"){
            $this->_oDb = MysqlPdo::getInstance($aConfig);
        }else{
            echo "没有要保存的数据仓库类型";
            exit;
        }
    }

    public function query($sql){
        return $this->_oDb->querySql($sql);
    }
}