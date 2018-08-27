<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 16:48
 */

namespace GliderSky\framework\data;

use GliderSky\lib\MysqlPdo;

class ModelService
{
    private $_sModel = null;

    public function __construct($model)
    {
        $this->_sModel = new $model();
    }

    public function query($sql){
        return $this->_sModel->query(str_replace("{table}",$this->_sModel->table,$sql));
    }
}