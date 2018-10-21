<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:41
 */

namespace test\model;

use GliderSky\framework\common\BaseModel;

class UsChinaCodeModel extends BaseModel{
    public $connect = "STOCK";
    public $table = "us_china_code";

    public function __construct()
    {
        parent::__construct();
    }
}