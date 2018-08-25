<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/19
 * Time: 20:57
 */

namespace GliderSky\framework\arithmetic;

class StockService
{
    private $_sModel = null;

    private static $aArithmeticName = [
        "urdgt" => "upRateDayGreateTwo",
        "sraug" => "sumRate12AndUprateGreate1",
        "sraul" => "sumRate12AndUprateLess1",
    ];

    public function calculate($name,$model,$rulenum){
        $sAction = self::$aArithmeticName[$name];
        $this->_sModel = new $model();
        $this->getSumData($sAction,$rulenum);
    }

    private function getCode(){
        return $this->_sModel->query("select distinct code from {$this->_sModel->table};");
    }

    private function getSumData($sRuleFunction,$iRuleCnt){
        $rs = $this->getCode();
        $all = array();
        foreach($rs as $sCode){
            $sum = 1;
            $temp = array();
            $rs1 = $this->_sModel->query("select day,now_price,up_rate,buy_sum from {$this->_sModel->table} where code='{$sCode['code']}' order by day desc limit 10");
            $temp["option"] = array_reverse($rs1);
            foreach($temp["option"] as $key=>$val){
                if($sum != 0){
                    $temp["option"][$key]["sum_rate"] = $val["buy_sum"]/$sum;
                }else{
                    $temp["option"][$key]["sum_rate"] = 1;
                }
                $sum = $val["buy_sum"];
            }
            $sql = "select ";
            $sql .= "max(now_price) as max_now_price,min(now_price) as min_now_price,";
            $sql .= "max(up_rate) as max_up_rate,min(up_rate) as min_up_rate,";
            $sql .= "max(buy_sum) as max_buy_sum,min(buy_sum) as min_by_sum ";
            $sql .= "from {$this->_sModel->table} where code='{$sCode['code']}' order by day desc limit 10";
            $temp["sum"] = $this->_sModel->query($sql);
            $all[$sCode['code']] = $temp;
        }
        foreach($all as $sCode=>$aData){
            $aCulcData = array_reverse($aData["option"]);
            $num = 0;
            foreach($aCulcData as $i => $row){
                if($this->$sRuleFunction($row)){
                    $num++;
                }else{
                    break;
                }
            }
            if($num > $iRuleCnt){
                $this->output($aCulcData,$sCode);
            }
        }
    }

    public function upRateDayGreateTwo($row){
        if($row["up_rate"] > 2) {
            return true;
        }else{
            return false;
        }
    }

    public function sumRate12AndUprateGreate1($row){
        if($row["sum_rate"] < 1.2 and abs($row["up_rate"]) > 0.01){
            return true;
        }else{
            return false;
        }
    }

    public function sumRate12AndUprateLess1($row){
        if($row["sum_rate"] < 1.2 and abs($row["up_rate"]) < 0.01){
            return true;
        }else{
            return false;
        }
    }

    function output($aCulcData,$sCode){
        echo "\n-------------------{$sCode}------------------------------\n";
        foreach($aCulcData as $i => $row){
            foreach($row as $key=>$val){
                echo $key.":".$val."\t";
            }
            echo "\n";
        }
    }
}