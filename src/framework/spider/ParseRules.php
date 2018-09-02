<?php
namespace GliderSky\framework\spider;

use GliderSky\lib\DateType;

class ParseRules {
    private $_aData = array();

    public function getData($sRule,$aContent){
        $aRules = explode("|", $sRule);
        $sPrev = "";
        $sIsArray = false;
        $aResult = array();
        $iRuleCnt = count($aRules)-1;
        foreach($aRules as $m=>$sRuleOption){
            if(!$sIsArray){
                $this->parseRule($sRuleOption,$aContent,$sPrev); 
                if(is_array($aContent)){
                    $sIsArray = true;
                }
                if($m == $iRuleCnt){
                    $aResult = $aContent;
                }
            }else{
                foreach($aContent as $i=>$row){
                    $x = $m;
                    if(substr($sRuleOption,0,6) == "array@"){
                        list($sType,$sIndex) = explode("@",$sRuleOption);
                        if($i < $sIndex) continue;
                    }     
                    if(substr($sRuleOption,0,6) == "array@"){
                        $x++;
                    }
                    for($n=$x;$n<count($aRules);$n++){       
                        $this->parseRule($aRules[$n],$row,$sPrev);                        
                    }
                    $aResult[] = $row;
                }
            }
        }
        return $aResult;        
    }
    
    public function saveData($aData,$sSaveRule,$aParams){
        $aResult = array("act_date" => date("YmdHis"));
        $aRules = explode(":", $sSaveRule);
        if($aRules[0] == "table"){
            $aFields = explode(",", $aRules[3]);
            foreach($aFields as $row){
                $aOption = explode("@",$row);    
                $sField = trim($aOption[0]);
                if(strstr($aOption[1],"const")){
                    list($sType,$sConstVal) = explode("-", $aOption[1]);
                    $aResult[$sField] = $sConstVal;
                }else{
                    $sIndex = $aOption[1];
                    if(strstr($sIndex,"{")){
                        $aResult[$sField] = DateType::replace($sIndex, $aParams);
                    }else{
                        if(!empty($aData[$sIndex])){
                            $aResult[$sField] = $aData[$sIndex];
                        }else{
                            $aResult[$sField] = "";
                        }
                        if(!empty($aOption[2])){    
                            $aOption[2] = str_replace("-", "@", $aOption[2]);
                            $sPrev = "";
                            $this->parseRule($aOption[2], $aResult[$sField], $sPrev);
                        }
                    }
                }
                if(isset($aOption[2]) and strstr($aOption[2],"notnull") and empty($aResult[$sField])){
                    return false;
                }
            }
        }
        return $aResult;
    }
    
    private function parseRule($sRuleOption,&$aContent,&$sPrev){
        $aOption = explode("@",$sRuleOption);
        if($aOption[0] == "iconv"){
            if($aOption[2] == "utf_8"){
                $aOption[2] = "utf-8";
            }
            $aContent = iconv($aOption[1],$aOption[2],$aContent);
        }elseif($aOption[0] == "json_decode"){
            $aContent = json_decode($aContent);
        }elseif($aOption[0] == "strpos"){
            if(!empty($aOption[3])){
                $sTempIndex = $aOption[3];
            }else{
                $sTempIndex = 0;
            }
            if(empty($aOption[2])){
                $sPrev = strpos($aContent, $aOption[1],$sTempIndex);
            }else{
                $sPrev = strpos($aContent, $aOption[1],$sTempIndex)+$aOption[2];
            }
        }elseif($aOption[0] == "reg"){
           if($aOption[1] == "json"){
                preg_match_all("/\[(.*)\]/", $aContent, $aMatchs);                
            }else{
                preg_match_all(addslashes($aOption[1]), $aContent, $aMatchs);
            }
            if(isset($aOption[2])){
                $aContent = $aMatchs[0][$aOption[2]];
            }else{
                $aContent = $aMatchs[0];
            }
            return "";
        }elseif($aOption[0] == "substr"){
            if($aOption[1] == "start"){
                $sPrev = $aContent = substr($aContent,$sPrev);
                return "";
            }elseif($aOption[1] == "0" and $aOption[2] == "end"){
                $sPrev = $aContent = substr($aContent,0,$sPrev);
                return "";
            }else{
                if($aOption[2] == "end"){
                    $sPrev = $aContent = substr($aContent,$aOption[1],$sPrev);
                }else{
                    $sPrev = $aContent = substr($aContent,$aOption[1],$aOption[2]);
                }
                return "";
            }
        }elseif($aOption[0] == "str_replace"){
            $aContent = str_replace($aOption[1], $aOption[2], $aContent);
            return "";
        }elseif($aOption[0] == "strtolower"){
            $aContent = strtolower($aContent);
            return "";
        }elseif($aOption[0] == "explode"){
            $aContent = explode($aOption[1],$aContent);
            return "";
        }
    }
    
}