<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 19:41
 */

namespace test\model;

use GliderSky\framework\common\BaseModel;

class ChinaSzPriceModel extends BaseModel{
    public $connect = "STOCK";
    public $table = "china_sz_price";
    public $recommand_table = "china_sz_recommand";

    public function __construct()
    {
        parent::__construct();
    }
}