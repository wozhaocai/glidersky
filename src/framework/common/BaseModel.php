<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:40
 */

namespace GliderSky\framework\common;

use GliderSky\framework\data\DataService;

class BaseModel
{
    protected $_db = null;

    public function __construct()
    {
        $this->_db = new DataService($this);
        return $this;
    }

    public function query($query){
        return $this->_db->query($query);
    }
}