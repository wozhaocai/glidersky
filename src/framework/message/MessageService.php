<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/24
 * Time: 11:28
 */

namespace GliderSky\framework\message;

use Qcloud\Sms\SmsSingleSender;

class MessageService
{
    private $_aConfig = array();

    public function __construct($name)
    {
        $this->_aConfig = \Config::$Config["sms"][$name];
    }

    public function sendAlert($code,$type){
        $this->sendSms($code.time(),$type);
    }

    private function sendSms($code, $type)
    {
        try {
            $ssender = new SmsSingleSender($this->_aConfig["appid"], $this->_aConfig["appkey"]);
            $params = [$code, $type];//数组具体的元素个数和模板中变量个数必须一致，例如事例中 templateId:5678对应一个变量，参数数组中元素个数也必须是一个
            $result = $ssender->sendWithParam("86", $this->_aConfig["phone"], $this->_aConfig["templateId"],
                $params, $this->_aConfig["smsSign"], "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result);
            echo $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
    }
}