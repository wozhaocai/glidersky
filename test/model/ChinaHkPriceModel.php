<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:41
 */

namespace test\model;

use GliderSky\framework\common\BaseModel;

class ChinaHkPriceModel extends BaseModel{
    public $connect = "STOCK";
    public $table = "china_hk_price";
    public $recommand_table = "china_hk_recommand";

    public function __construct()
    {
        parent::__construct();
    }
}