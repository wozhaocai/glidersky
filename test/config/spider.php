<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 23:02
 */

return [
    "US_CHINA" => [
        "url" => "https://hq.sinajs.cn?_=0.659323{date|}&list=gb_{code}",
        "parse_rule" => 'iconv@GBK@utf-8|reg@/"(.*)"/@0|substr@1@-1|explode@,',
        "save_rule" => 'table:us_china_price:one:day@3@substr-0-10,
            code@{code},cname@0,now_price@1,up_rate@2,
            up_price@4,start_price@5,highest_price@6,lowest_price@7,
            highest_price_52week@8,lowest_price_52week@9,buy_sum@10,
            buy_sum_avg_10day@11,market_cap@12,earn_per@13,market_rate@14
            ,pager_sum@19,end_price@21,yesterday_price@26',
        "starttime" => "12:30",
        "endtime" => "18:00"
    ]
];