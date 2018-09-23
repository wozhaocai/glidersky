<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:41
 */

namespace test\model;

use GliderSky\framework\common\BaseModel;

class StockqueueModel extends BaseModel{
    public $connect = "STOCK";
    public $table = "stock_queue";

    public function __construct()
    {
        parent::__construct();
    }
}