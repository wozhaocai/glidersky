<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:41
 */

namespace test\model;

use GliderSky\framework\common\BaseModel;

class UsChinaPriceModel extends BaseModel{
    public $connect = "STOCK";
    public $table = "us_china_price";

    public function __construct()
    {
        parent::__construct();
    }
}